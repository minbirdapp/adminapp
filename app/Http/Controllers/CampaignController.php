<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Brand;
use App\Models\Trackers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CampaignController extends Controller
{

    public function create($id = null)
    {
        $user = Auth::user();
        $campaign = Campaign::with(['trackingUrls'])->where('id', $id)->first();
        $brands = Brand::with('social_medias')
            ->where('user_id', $user->id)
            ->get();
        return view('campaign.create', compact('user', 'brands', 'campaign'));
    }

    public function list()
    {
        $user = Auth::user();
        $list = Campaign::where('user_id', $user->id)
            ->paginate(10);
        return view('campaign.list', compact('user', 'list'));
    }

    public function storeCampaign(Request $request)
    {
        try {
            $data = $request->all();
            $data['start_date'] = date('Y-m-d', strtotime($request->get('start_date')));
            if (!empty($request->get('end_date'))) {
                $data['end_date'] = date('Y-m-d', strtotime($request->get('end_date')));
            }
            $data['user_id'] = Auth::user()->id;
            $data['tenant_id'] = Auth::user()->id;
            $tracker = null;
            if (isset($data['tracker'])) {
                $tracker = $data['tracker'];
                unset($data['tracker']);
            }
            unset($data['_token']);
            if (isset($data['id']) && !empty($data['id'])) {
                Campaign::where('id', $data['id'])->update($data);
                Trackers::where([
                    'campaign_id' => $data['id']
                ])->delete();
                $campaignId = $campId = $data['id'];
                $msg = 'Campaign has been updated successfully.';
            } else {
                $campId = Campaign::create($data);
                $msg = 'Campaign has been created successfully.';
                $campaignId = $campId->id;
            }
            if (!empty($tracker)) {
                $count = 0;
                foreach ($tracker['name'] as $v) {
                    Trackers::create([
                        'name' => $tracker['name'][$count],
                        'url' => $tracker['url'][$count],
                        'user_id' => Auth::user()->id,
                        'tenant_id' => Auth::user()->id,
                        'campaign_id' => $campaignId
                    ]);
                    $count++;
                }
            }
            session()->flash('success', $msg);
            return redirect()
                ->route('campaign.list');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return redirect()
                ->route('campaign.list');
        }
    }

    public function view(Request $request)
    {
        $id = $request->get('id');
        $campaign = Campaign::with(['trackingUrls'])->where('id', $id)->first();
        return view('campaign.view', compact('campaign'));
    }

    public function delete($id = null)
    {
        $campaign = Campaign::with(['trackingUrls'])->where('id', $id)->first();
        if ($campaign) {
            Trackers::where('campaign_id', $id)->delete();
            $campaign->delete();
            return redirect()->route('campaign.list')->with('success', 'Campaign has been deleted successfully!');
        }
        return redirect()->route('campaign.list')->with('error', 'Deleting Failed !');
    }
}
