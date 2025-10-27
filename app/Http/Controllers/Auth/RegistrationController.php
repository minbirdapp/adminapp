<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use App\Models\User;
use Illuminate\Support\Facades\Http;

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
    // Validate input + recaptcha
    $request->validate([
        'email' => 'required|email',
        'g-recaptcha-response' => 'required',
    ]);

    // 🔒 Verify reCAPTCHA with Google
    $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
        'secret' => env('RECAPTCHA_SECRET'),
        'response' => $request->input('g-recaptcha-response'),
        'remoteip' => $request->ip(),
    ]);

    $recaptcha = $response->json();

    if (!($recaptcha['success'] ?? false)) {
        return back()->withErrors(['captcha' => 'Captcha verification failed. Please try again.'])->withInput();
    }

    // Optional: if using Enterprise and you want to check score
    if (isset($recaptcha['score']) && $recaptcha['score'] < 0.5) {
        return back()->withErrors(['captcha' => 'Suspicious activity detected.'])->withInput();
    }

    // ✅ Continue original logic
    $user = User::firstOrCreate(['email' => $request->email], [
        'name' => '',
        'password' => Hash::make(Str::random(12)),
    ]);

    $url = URL::temporarySignedRoute('register.verify', now()->addMinutes(30), ['user' => $user->id]);
    Mail::to($user->email)->send(new MagicLinkMail($url));

    return "Magic link sent to " . $user->email;
}

}
