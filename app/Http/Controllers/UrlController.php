<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class UrlController extends Controller
{
public function generate(Request $request)
{
    $request->validate([
        'long_url' => 'required|url'
    ]);

    $clientId = Auth::user()->client_id;
    $userRole = Auth::user()->role;

    
    $existing = Url::where('long_url', $request->long_url)
                   ->where('user_id', Auth::id())
                   ->where('client_id', $clientId)  
                   ->first();
                   
    if ($existing) {
        
        $existing->increment('hits');
        session()->flash('message', 'URL already exists. Hits increased to ' . $existing->hits);     
        
        return ($userRole == 'super_admin') ? redirect()->route('admin.urls') : redirect()->route('client.urls');
    }

   
    $short = Str::random(6);

    
    Url::create([
        'long_url' => $request->long_url,
        'short_url' => $short,
        'user_id' => Auth::id(),
        'client_id' => $clientId,  
        'hits' => 1
    ]);

    session()->flash('message', 'Short URL created successfully');    

    return ($userRole == 'super_admin') ? redirect()->route('admin.urls') : redirect()->route('client.urls');
}


    public function myUrls()
    {
        return view('urls.index', ['urls' => Auth::user()->urls()->paginate(10)]);
    }
}
