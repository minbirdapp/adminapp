<?php

use App\Models\UserProfile;
use Illuminate\Support\Facades\Auth;

if (!function_exists('getProfileData')) {
    function getProfileData()
    {
        return UserProfile::where('user_id', Auth::user()->id)->first();
    }
}




