<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\User;
use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ClientAdminController extends Controller
{
    public function dashboard()
    {
        return view('client.dashboard');
    }

public function listTeam()
{
    $team = Invitation::where('client_id', Auth::user()->client_id)
                      ->whereHas('curls', function ($query) {
                          $query->where('user_id', Auth::user()->id)  
                                ->where('client_id', Auth::user()->client_id); 
                      })
                      ->withCount([
                          'curls as urls_count' => function ($query) {                              
                              $query->where('user_id', Auth::user()->id)  
                                    ->where('client_id', Auth::user()->client_id) 
                                    ->selectRaw('COUNT(CASE WHEN long_url IS NOT NULL THEN 1 END) + COUNT(CASE WHEN short_url IS NOT NULL THEN 1 END) as count');
                          },
                      ])
                      ->with(['curls' => function ($query) {
                          $query->where('user_id', Auth::user()->id)
                                ->where('client_id', Auth::user()->client_id);
                      }])
                      ->paginate(10);
					  $team->getCollection()->transform(function ($member) {        
        $member->urls_sum_hits = $member->curls->sum('hits');
        return $member;
    });

    return view('client.team', compact('team'));
}


    public function inviteTeam(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'role' => 'required|in:admin,member',
        ]);

        $invitation = Invitation::create([
            'email' => $request->email,
            'client_id' => Auth::user()->client_id,
            'role' => $request->role,
            'expires_at' => now()->addMinutes(30),
            'token' => Str::random(32),
        ]);

       
		//Mail::to($request->email)->send(new \App\Mail\InviteMail($invitation));

        return back()->with('success', 'Team member invited successfully');
    }

   	
public function listUrls(Request $request)
{
    $query = Url::with('client')
        ->whereHas('user', function ($query) {
            $query->where('user_id', Auth::id());
        });
    
    if ($request->has('filter')) {
        switch ($request->filter) {
            case 'today':
                $query->whereDate('created_at', now()->toDateString());
                break;
            case 'this_month':
                $query->whereMonth('created_at', now()->month)
                      ->whereYear('created_at', now()->year);
                break;
            case 'last_month':
                $query->whereMonth('created_at', now()->subMonth()->month)
                      ->whereYear('created_at', now()->subMonth()->year);
                break;
            case 'last_week':
                $query->whereBetween('created_at', [
                    now()->subWeek()->startOfWeek(),
                    now()->subWeek()->endOfWeek(),
                ]);
                break;
        }
    }

    $urls = $query->paginate(10);
    return view('client.urls', compact('urls'));
}
    public function downloadUrls()
    {
        $urls = Url::whereHas('user', function ($query) {
            $query->where('client_id', Auth::user()->client_id);
        })->get();

        $csvFileName = 'team-urls.csv';

        return response()->streamDownload(function() use ($urls) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Long URL', 'Short URL', 'Hits']);

            foreach ($urls as $url) {
                fputcsv($handle, [$url->long_url, $url->short_url, $url->hits]);
            }

            fclose($handle);
        }, $csvFileName);
    }
}
