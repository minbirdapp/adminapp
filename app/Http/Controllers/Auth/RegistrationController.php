<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use App\Models\User;
use App\Mail\MagicLinkMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function showCreateAccount()
    {
        return view('auth.create-account');
    }

    public function sendMagicLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::firstOrCreate(['email' => $request->email], [
            'name' => '',
            'password' => Hash::make(Str::random(12)),
        ]);

        $url = URL::temporarySignedRoute('register.verify', now()->addMinutes(30), ['user' => $user->id]);
        Mail::to($user->email)->send(new MagicLinkMail($url));

        return "Magic link sent to " . $user->email;
    }
}
