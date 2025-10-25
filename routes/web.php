<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChannelSetupController;

Route::get('/', function () {
    if (auth()->check()) {
        // User is logged in → go to dashboard
        return redirect()->route('dashboard');
    }
    // User is not logged in → go to create account
    return redirect()->route('create.account');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/create-account', [AuthController::class, 'showCreateAccount'])->name('create.account');
Route::post('/create-account', [AuthController::class, 'register'])->name('register');

Route::get('/magic-link', [AuthController::class, 'showMagicLink'])->name('magic.link');
Route::post('/magic-link', [AuthController::class, 'sendMagicLink'])->name('magic.send');

Route::post('/activate-code', [AuthController::class, 'activateByCode'])->name('activate.code');
Route::get('/activate/{token}', [AuthController::class, 'activateAccount'])->name('activate');
Route::get('/activation-code', function () {
    return view('auth.activation-code'); 
})->name('activate.code.page');
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');

// Show password login form
Route::get('/login', [AuthController::class, 'showPasswordLogin'])->name('password.login');

// Handle password login
Route::post('/login', [AuthController::class, 'passwordLogin'])->name('password.login.submit');

Route::get('/activation-success', function () {
    return view('auth.activation-success');
})->name('activation.success');
Route::get('/setup-account', [AuthController::class, 'showSetupAccount'])->name('setup.account');
Route::post('/setup-account', [AuthController::class, 'storeSetupAccount'])->name('setup.account.store');

Route::middleware(['auth'])->group(function () {
    Route::get('/setup-channels', [ChannelSetupController::class, 'index'])->name('setup.channels');
    Route::post('/brands/store', [ChannelSetupController::class, 'storeBrand'])->name('brands.store');
});