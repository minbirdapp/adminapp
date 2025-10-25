<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Brand;
use App\Models\Industry;
use App\Models\UserProfile;

class ChannelSetupController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // active industries for the select
        $industries = Industry::where('status', '1')->get();

        // user's brands to show existing brand cards
        $brands = Brand::where('user_id', $user->id)->get();

        // user profile if needed
        $profile = UserProfile::where('user_id', $user->id)->first();

        // make sure view name matches your file path
        return view('auth.setup-channels', compact('industries', 'brands', 'profile'));
    }

    // store method if using same controller for brand creation (optional)
    public function storeBrand(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'industry_id' => 'nullable|integer|exists:industries,id',
            'competitor_info' => 'nullable|string',
            'intro' => 'nullable|string',
        ]);

        $brand = Brand::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'industry_id' => $request->industry_id,
            'competitor_info' => $request->competitor_info,
            'intro' => $request->intro,
        ]);

        return response()->json(['success' => true, 'brand' => $brand]);
    }
}
