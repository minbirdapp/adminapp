<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\PaymentPlan;
use App\Models\Trackers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function storeCampaign(Request $request)
    {
        try {
            $data = $request->all();
            $data['start_date'] = date('Y-m-d', strtotime($request->get('start_date')));
            $data['end_date'] = date('Y-m-d', strtotime($request->get('end_date')));
            $data['user_id'] = Auth::user()->id;
            $data['tenant_id'] = Auth::user()->id;
            $tracker = $data['tracker'];
            unset( $data['tracker']);
            $campId = Campaign::create($data);
            if (!empty($tracker)) {
                $count =0 ;
                foreach ($tracker['name'] as $v) {
                    Trackers::create([
                        'name' => $tracker['name'][$count],
                        'url' => $tracker['url'][$count],
                        'user_id' => Auth::user()->id,
                        'tenant_id' => Auth::user()->id,
                        'campaign_id' => $campId->id
                    ]);
                    $count++;
                }
            }
            return redirect()
                ->route('dashboard')
                ->with('success', 'Campaign has been created successfully.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()
                ->route('dashboard')
                ->with('error', $e->getMessage());
        }
    }
}
