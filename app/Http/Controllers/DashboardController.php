<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class DashboardController extends Controller
{
    public function index()
    {
        $brands = Brand::where([
            'user_id' => FacadesAuth::user()->id
        ])->get();
        return view('dashboard.dashboard-area', compact('brands'));
    }
}
