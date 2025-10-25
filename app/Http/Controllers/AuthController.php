<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\MagicLinkMail;
use App\Models\Brand;
use Carbon\Carbon;
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
        $request->validate([
            'email' => 'required|email|unique:users,email',
        ]);

        $user = User::create([
            'name' => 'Minbird User',
            'email' => $request->email,
            'password' => bcrypt(Str::random(16)),
            'activation_code' => mt_rand(100000, 999999), // 6-digit numeric code
            'activation_code_expires_at' => Carbon::now()->addMinutes(15),
        ]);

        // Send activation email
        Mail::to($user->email)->send(new MagicLinkMail($user->activation_code));

        return redirect()->route('magic.link')->with('success', 'Activation code sent to your email!');
    }

    // Show Magic Link page
    public function showMagicLink()
    {
        return view('auth.magic-link');
    }

    // Resend magic link / code
    public function sendMagicLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        // 1. Generate activation code
        $code = rand(100000, 999999);
        $user->activation_code = $code;
        $user->activation_code_expires_at = now()->addMinutes(10);
        $user->save();

        // 2. Send mail with the code
        \Mail::to($user->email)->send(new \App\Mail\MagicLinkMail($user->activation_code));

        // 3. Redirect to activation page with the email
        return redirect()
            ->route('activate.code.page', ['email' => $user->email])
            ->with('success', 'We’ve sent you an email with your activation code.');
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
        return redirect()->route('activation.success')->with('success', 'Your account is activated!');
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
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string',
        ]);

        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            // Login successful
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->withInput();
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
