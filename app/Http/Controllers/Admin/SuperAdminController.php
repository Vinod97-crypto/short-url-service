<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Invitation;
use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
		$clients = Client::all();
        return view('admin.dashboard', compact('clients'));
    }
	
public function listClients()
{
    $clients = Client::query()
        ->select('clients.id', 'clients.name') 
        ->withCount([
            'invitations as users_count' => function ($query) {
                $query->selectRaw('COUNT(*)'); 
            },
        ])
        ->withCount([
            'urls as urls_count' => function ($query) {
                $query->selectRaw('COUNT(long_url) + COUNT(short_url)'); 
            },
        ])
        ->withSum('urls as urls_sum_hits', 'hits') 
        ->paginate(10);	

    return view('admin.clients', ['clients' => $clients]);
}


public function inviteClient(Request $request)
{
    $request->validate([
        'email' => 'required|email|unique:invitations',
        'name' => 'required|string'
    ]);

    $superAdminId = Auth::id();    
    $client = Client::create([
        'name' => $request->name,
        'super_admin_id' => $superAdminId,
    ]);

    
    $invitation = Invitation::create([
        'email' => $request->email,
        'client_id' => $client->id,
        'role' => 'admin',
        'expires_at' => now()->addMinutes(30),
        'token' => Str::random(32),
    ]);

    
    //Mail::to($request->email)->send(new \App\Mail\InviteMail($invitation));
    return back()->with('success', 'Invitation sent successfully');
}


public function listUrls(Request $request)
{
    $query = Url::with('client');

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
    return view('admin.urls', ['urls' => $urls]);
}

    public function downloadUrls()
    {
        $urls = Url::all();
        $csvFileName = 'urls.csv';
        
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
