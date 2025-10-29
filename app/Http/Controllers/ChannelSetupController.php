<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Brand;
use App\Models\Industry;
use App\Models\UserProfile;
use App\Models\BrandSocialMediaAccount;

class ChannelSetupController extends Controller
{
    public function showChannels()
    {
        $user = Auth::user();
        $industries = Industry::where('status', '1')->get();
        $brands = Brand::with(['social_medias'])->where('user_id', $user->id)->get();
        $profile = UserProfile::where('user_id', $user->id)->first();

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

        return redirect()->route('setup.channels')->with('success', 'Brand added successfully!');
    }


    public function addSocialMediaAccount(Request $request)
    {
        $checkExists = BrandSocialMediaAccount::where([
            'user_id' => Auth::user()->id,
            'brand_id' => $request->get('brand_id'),
            'account_type' => $request->get('account_type'),
        ])->first();
        if (empty($checkExists)) {
            BrandSocialMediaAccount::create([
                'user_id' => Auth::user()->id,
                'tenant_id' => Auth::user()->id,
                'brand_id' => $request->get('brand_id'),
                'account_type' => $request->get('account_type'),
            ]);
            echo json_encode([
                'status' => true,
                'message' => 'Social media account added successfully.'
            ]);
        } else {
            echo json_encode([
                'status' => false,
                'message' => 'Social media account already exists.'
            ]);
        }
        return false;
    }
}
