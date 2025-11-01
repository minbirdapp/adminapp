<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\UserProfile;
use App\Models\Timezone;

class ProfileController extends Controller
{
    /**
     * Display the logged-in user's profile page.
     */
    public function index()
    {
        // Ensure a profile record exists for the logged-in user
        $profile = UserProfile::firstOrCreate(
            ['user_id' => Auth::id()],
            [
                'first_name' => '',
                'last_name' => '',
                'role' => '',
                'bio' => '',
                'timezone_id' => null
            ]
        );

        // Fetch all timezones from DB
        $timezones = Timezone::orderBy('label')->get();

        return view('profile', compact('profile', 'timezones'));
    }

    /**
     * Update the logged-in user's profile.
     */
    public function update(Request $request)
    {
        $request->validate([
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'role'          => 'nullable|string|max:255',
            'bio'           => 'nullable|string|max:1000',
            'timezone_id'   => 'nullable|integer|exists:timezones,id',
            'profile_image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $profile = UserProfile::where('user_id', Auth::id())->firstOrFail();

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($profile->profile_image) {
                Storage::disk('public')->delete('profile/' . $profile->profile_image);
            }

            // Store new image
            $filename = time() . '.' . $request->file('profile_image')->getClientOriginalExtension();
            $request->file('profile_image')->storeAs('public/profile', $filename);
            $profile->profile_image = $filename;
        }

        // Update text fields
        $profile->update([
            'first_name'  => $request->first_name,
            'last_name'   => $request->last_name,
            'role'        => $request->role,
            'bio'         => $request->bio,
            'timezone_id' => $request->timezone_id,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
