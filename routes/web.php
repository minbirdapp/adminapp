<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChannelSetupController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;                    
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\TeamMemberController;


Route::get('/', function () {
    if (auth()->check()) {
        // User is logged in → go to dashboard
        return redirect()->route('dashboard');
    }
    // User is not logged in → go to create account
    return redirect()->route('create.account');
});

Route::post('/logout', function (Request $request) {
    Auth::logout(); // log out the user
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // redirect to magic link page
    return redirect()->route('magic.link')->with('success', 'You have been logged out successfully.');
})->name('logout');

Route::get('/create-account', [AuthController::class, 'showCreateAccount'])->name('create.account');
Route::post('/create-account', [AuthController::class, 'register'])->name('register');

Route::get('/magic-link', [AuthController::class, 'showMagicLink'])->name('magic.link');
Route::post('/magic-link', [AuthController::class, 'sendMagicLink'])->name('magic.send');

Route::post('/activate-code', [AuthController::class, 'activateByCode'])->name('activate.code');
Route::get('/activate/{token}', [AuthController::class, 'activateAccount'])->name('activate');
Route::get('/activation-code', [AuthController::class, 'showActivationCodePage'])->name('activate.code.page');
Route::post('/activation-code', [AuthController::class, 'activateByCode'])->name('activate.code');
Route::get('/resend-activation-code', [AuthController::class, 'resendActivationCode'])->name('resend.code');

// Show password login form
Route::get('/login', [AuthController::class, 'showPasswordLogin'])->name('password.login');

// Handle password login
Route::post('/login', [AuthController::class, 'passwordLogin'])->name('password.login.submit');

Route::get('/activation-success', function () {
    return view('auth.activation-success');
})->name('activation.success');


Route::middleware(['auth'])->group(function () {
    Route::get('/setup-account', [AuthController::class, 'showSetupAccount'])->name('setup.account');
    Route::post('/setup-account', [AuthController::class, 'storeSetupAccount'])->name('setup.account.store');
    Route::get('/setup-channels', [ChannelSetupController::class, 'showChannels'])->name('setup.channels');
    Route::post('/add-media-accounts', [ChannelSetupController::class, 'addSocialMediaAccount'])->name('brand.addSocialMediaAccount');
    Route::post('/brands/store', [ChannelSetupController::class, 'storeBrand'])->name('brands.store');
    Route::post('/campaign/create', [CampaignController::class, 'storeCampaign'])->name('campaign.create');
    Route::get('/setup-payment', [App\Http\Controllers\PaymentController::class, 'setupPayment'])->name('setup.payment');
    Route::get('/confirm-payment/{id}', [App\Http\Controllers\PaymentController::class, 'confirmPayment'])->name('setup.confirm');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/change-password', [PasswordController::class, 'index'])->name('password.change');
    Route::post('/change-password', [PasswordController::class, 'update'])->name('password.update');
    Route::get('/app-settings-channels', [ChannelSetupController::class, 'appSettings'])->name('app.settingschannel');
    Route::post('/add-social-account', [ChannelSetupController::class, 'addSocialMediaAccount'])->name('add.social.account');
    Route::get('/app-settings-teams', [TeamMemberController::class, 'index'])->name('team-members.index');
Route::post('/app-settings-teams', [TeamMemberController::class, 'store'])->name('team-members.store');
Route::get('/app-settings-teams', [App\Http\Controllers\TeamMemberController::class, 'index'])
    ->name('app.settings.teams');
Route::get('/team-members/{id}/view', [App\Http\Controllers\TeamMemberController::class, 'view'])->name('team-members.view');

Route::resource('team-members', TeamMemberController::class);


});

Route::get('/app-settings', function () {
    return view('app-settings');
})->middleware('auth')->name('app.settings');

