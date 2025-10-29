<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\MagicLinkMail;
use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    // Show Create Account page
    public function showCreateAccount()
    {
        return view('auth.create-account');
    }

    // Handle registration
    public function register(Request $request)
    {
        try {
            // Validate input
            $request->validate([
                'email' => 'required|email',
                'g-recaptcha-response' => 'required',
            ]);

            // Verify Google reCAPTCHA
            $secretKey = env('CAPTCHA_SECRET_KEY');
            $response = $request->input('g-recaptcha-response');
            $remoteIp = $request->ip();

            $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$response}&remoteip={$remoteIp}");
            $responseKeys = json_decode($verify, true);

            if (!($responseKeys['success'] ?? false)) {
                return back()->with('error', 'Captcha verification failed. Please try again.');
            }

            // ✅ Check if user already exists
            $existingUser = User::where('email', $request->email)->first();
            if ($existingUser) {
                return back()->with('error', 'This email is already registered. Please try logging in.');
            }

            // Create new user
            $user = User::create([
                'name' => 'Minbird User',
                'email' => $request->email,
                'password' => bcrypt(\Illuminate\Support\Str::random(16)),
            ]);

            // Generate activation code
            $code = rand(100000, 999999);
            $user->activation_code = $code;
            $user->activation_code_expires_at = now()->addMinutes(10);
            $user->save();

            // Send activation email
            \Mail::to($user->email)->send(new \App\Mail\MagicLinkMail($user->activation_code));

            // Redirect to activation code page
            return redirect()
                ->route('activate.code.page', ['email' => $user->email])
                ->with('success', 'Success Message');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }



    // Show Magic Link page
    public function showMagicLink()
    {
        return view('auth.magic-link');
    }

    // Resend magic link / code
    public function sendMagicLink(Request $request)
    {
        try {
            //  Validate input
            $request->validate([
                'email' => 'required|email|exists:users,email',
                'g-recaptcha-response' => 'required',
            ]);

            // Verify Google reCAPTCHA
            $secretKey = env('CAPTCHA_SECRET_KEY');
            $response = $request->input('g-recaptcha-response');
            $remoteIp = $request->ip();

            $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$response}&remoteip={$remoteIp}");
            $responseKeys = json_decode($verify, true);

            if (!($responseKeys['success'] ?? false)) {
                return back()->with('error', 'Captcha verification failed. Please try again.');
            }

            //  Proceed if captcha is valid
            $user = User::where('email', $request->email)->first();

            // Generate new activation code
            $code = rand(100000, 999999);
            $user->activation_code = $code;
            $user->activation_code_expires_at = now()->addMinutes(10);
            $user->save();

            // Send mail
            \Mail::to($user->email)->send(new \App\Mail\MagicLinkMail($user->activation_code));

            return redirect()
                ->route('activate.code.page', ['email' => $user->email])
                ->with('success', 'Success Message');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
    public function showActivationCodePage(Request $request)
    {
        $email = $request->query('email');
        return view('auth.activation-code', compact('email'));
    }



    // Activate via GET link
    public function activateAccount($token)
    {
        $user = User::where('activation_code', $token)
            ->where('activation_code_expires_at', '>', Carbon::now())
            ->first();

        if (!$user) {
            return redirect()->route('magic.link')->with('error', 'Invalid or expired link.');
        }

        $user->email_verified_at = now();
        $user->activation_code = null;
        $user->activation_code_expires_at = null;
        $user->save();

        return redirect()->route('create.account')->with('success', 'Account verified successfully!');
    }

    // Activate via POST code
    public function activateByCode(Request $request)
    {
        $request->validate([
            'activation_code' => 'required',
        ]);

        $user = \App\Models\User::where('activation_code', $request->activation_code)->first();

        if (!$user) {
            return back()->with('error', 'Invalid activation code.');
        }

        if ($user->activation_code_expires_at && $user->activation_code_expires_at->isPast()) {
            return back()->with('error', 'Activation code expired. Please resend a new one.');
        }

        //  Mark user as verified
        $user->email_verified_at = now();
        $user->activation_code = null;
        $user->activation_code_expires_at = null;
        $user->save();

        auth()->login($user);

        //  Redirect to success page
        return redirect()->route('activation.success')->with('success', 'You’re all set');
    }

    public function resendActivationCode(Request $request)
    {
        try {
            $email = $request->query('email'); // Get ?email= from URL
            if (!$email) {
                return redirect()->route('create.account')->with('error', 'Email address missing.');
            }

            $user = User::where('email', $email)->first();
            if (!$user) {
                return redirect()->route('create.account')->with('error', 'User not found.');
            }

            // Generate new activation code
            $code = rand(100000, 999999);
            $user->activation_code = $code;
            $user->activation_code_expires_at = now()->addMinutes(10);
            $user->save();

            // Send email again
            \Mail::to($user->email)->send(new \App\Mail\MagicLinkMail($user->activation_code));

            return redirect()
                ->route('activate.code.page', ['email' => $user->email])
                ->with('success', 'A new activation code has been sent to your email.');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }


    // Show login form
    public function showPasswordLogin()
    {
        return view('auth.password-login');
    }

    // Handle login
    public function passwordLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'No account found with this email.');
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Incorrect password.');
        }

        Auth::login($user);
        return redirect()->route('dashboard')->with('success', 'Welcome back!');
    }

    public function showSetupAccount(Request $request)
    {
        $user = auth()->user();
        return view('auth.setup-account', compact('user'));
    }

    public function storeSetupAccount(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'nullable|string|max:255',
            'password'      => 'required|string|min:8',
            // 'password'      => 'required|string|min:8|confirmed',
            'brand_name'    => 'required|string|max:255',
            'industry_id'   => 'required|integer|exists:industries,id',
            'brand_role_id' => 'required|integer|exists:brand_roles,id',
            'about_brand'   => 'nullable|string',
        ]);


      $user->update([
    'name'     => trim($request->first_name . ' ' . $request->last_name),
    'password' => bcrypt($request->password),
]);
        // optional: store profile details in a user_profiles table
        \App\Models\UserProfile::updateOrCreate(
            ['user_id' => $user->id],
            $request->only(['first_name', 'last_name', 'brand_name', 'industry_id', 'brand_role_id', 'about_brand'])
        );
        $isBrandExists = Brand::where('name', $request->get('brand_name'))->first();
        if (empty(($isBrandExists))) {
            Brand::create([
                'user_id' => $user->id,
                'tenant_id' => $user->id,
                'name' =>  $request->get('brand_name'),
                'intro' => $request->get('about_brand'),
                'industry_id' => $request->get('industry_id'),
                'is_default' => 1
            ]);
        }
        return redirect()->route('setup.channels')->with('success', 'Account setup complete! Let’s connect your social channels.');
    }
}
