<?php

namespace App\Http\Controllers;

class ProfileController extends Controller 
{
    public function index() 
    {
        return view('profile.profile');
    }
    
    public function uploadVideo()
    {
        // Upload video

        return redirect()->route('profile.index');
    }

    public function showSettings()
    {
        return view('profile.settings');
    }
}
