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
        if ($request->get('record_id')) {
            $brand = Brand::where('id', $request->get('record_id'))->update([
                'name' => $request->name,
                'industry_id' => $request->industry_id,
                'competitor_info' => $request->competitor_info,
                'intro' => $request->intro,
            ]);
            if ($request->get('app-settings-brands') == 1) {
                return redirect()->route('app.settings.edit.brands', $request->get('record_id'))->with('success', 'Brand updated successfully!');
            }
            return redirect()->route('setup.channels')->with('success', 'Brand Updated successfully!');
        } else {
            $brand = Brand::create([
                'user_id' => Auth::id(),
                'name' => $request->name,
                'industry_id' => $request->industry_id,
                'competitor_info' => $request->competitor_info,
                'intro' => $request->intro,
            ]);
            if ($request->get('app-settings-brands') == 1) {
                return redirect()->route('app.settingsbrands')->with('success', 'Brand added successfully!');
            }
            return redirect()->route('setup.channels')->with('success', 'Brand added successfully!');
        }
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
            session()->flash('success', 'Social media account added successfully.');
            echo json_encode([
                'status' => true,
                'message' => 'Social media account added successfully.'
            ]);
        } else {
            session()->flash('error', 'Social media account already exists for the selected brand.');
            echo json_encode([
                'status' => false,
                'message' => 'Social media account already exists for the selected brand.'
            ]);
        }
        return false;
    }
    public function appSettings()
    {
        $user = Auth::user();
        $brands = Brand::with('social_medias')
            ->where('user_id', $user->id)
            ->get();

        return view('app-settings-channel', compact('user', 'brands'));
    }

    public function searchBrand(Request $request)
    {
        $user = Auth::user();
        $brands = Brand::with('social_medias')
            ->where('user_id', $user->id)
            ->where('name', 'Like', '%' . $request->get('search') . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);
            $brands->withPath('/app-settings-brands');

        return view('app-settings-brands-search', compact('user',  'brands'));
    }

    public function appBrands($id = null)
    {
        $user = Auth::user();
        $selectedBrand = Brand::with('social_medias')
            ->where('id', $id)
            ->first();
        $industries = Industry::where('status', '1')->get();
        $brands = Brand::with('social_medias')
            ->where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('app-settings-brands', compact('user', 'industries', 'brands', 'selectedBrand'));
    }

    public function deleteBrand($id = null)
    {
        $selectedBrand = Brand::with('social_medias')
            ->where('id', $id)
            ->first();
        if ($selectedBrand) {
            $selectedBrand->delete();
            return redirect()->route('app.settingsbrands')->with('success', 'Brand deleted successfully!');
        }
        return redirect()->route('app.settingsbrands')->with('error', 'Deleting Failed !');
    }
}
