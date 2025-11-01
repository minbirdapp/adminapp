<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PasswordController extends Controller
{
    public function index()
    {
        return view('change-password');
    }

 
public function update(Request $request)
{
    $request->validate([
        'current_password' => ['required'],
        'new_password' => [
            'required',
            'string',
            'min:8',
            'regex:/[A-Za-z]/',   // at least one letter
            'regex:/\d/',         // at least one number
            'regex:/[@$!%*#?&]/', // at least one special character
            'confirmed',          // matches new_password_confirmation
        ],
    ]);

    $user = auth()->user();

    //  Verify current password
    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Your current password is incorrect.']);
    }

    //  Update new password
    $user->update(['password' => Hash::make($request->new_password)]);

    return back()->with('success', 'Password updated successfully!');
}
}
