<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentPlan;

class PaymentController extends Controller
{
    public function setupPayment()
    {
        // Fetch only active plans
        $plans = PaymentPlan::where('status', 1)->get();

        return view('auth.setup-payment', compact('plans'));
    }


    public function confirmPayment($planId = null)
    {
        // Fetch only active plans
        $plan = PaymentPlan::where('id', $planId)->first();
        return view('payments.confirm-payment', compact('plan'));
    }
}
