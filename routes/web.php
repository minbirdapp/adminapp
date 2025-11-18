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
use App\Http\Controllers\PostController;

Route::get('/login', function () {
    return redirect()->route('magic.link')->with('success', 'You have been logged out successfully.');
})->name('login');
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
    Route::get('/campaign/create', [CampaignController::class, 'create'])->name('campaign.create');
    Route::get('/campaign/edit/{id}', [CampaignController::class, 'create'])->name('campaign.edit');
    Route::get('/campaign/delete/{id}', [CampaignController::class, 'delete'])->name('campaign.delete');
    Route::get('/campaign/view', [CampaignController::class, 'view'])->name('campaign.view');
    Route::get('/campaign/list', [CampaignController::class, 'list'])->name('campaign.list');
    Route::post('/campaign/create', [CampaignController::class, 'storeCampaign'])->name('campaign.store');
    Route::get('/setup-payment', [App\Http\Controllers\PaymentController::class, 'setupPayment'])->name('setup.payment');
    Route::get('/confirm-payment/{id}', [App\Http\Controllers\PaymentController::class, 'confirmPayment'])->name('setup.confirm');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/change-password', [PasswordController::class, 'index'])->name('password.change');
    Route::post('/change-password', [PasswordController::class, 'update'])->name('password.update');
    Route::get('/app-settings-channels', [ChannelSetupController::class, 'appSettings'])->name('app.settingschannel');
    Route::get('/app-settings-brands', [ChannelSetupController::class, 'appBrands'])->name('app.settingsbrands');
    Route::get('/search-brands', [ChannelSetupController::class, 'searchBrand'])->name('search.brand');
    Route::get('/app-settings-brands/{id}', [ChannelSetupController::class, 'appBrands'])->name('app.settings.edit.brands');
    Route::get('/app-settings-brand-delete/{id}', [ChannelSetupController::class, 'deleteBrand'])->name('app.settings.delete.brands');
    Route::post('/add-social-account', [ChannelSetupController::class, 'addSocialMediaAccount'])->name('add.social.account');
    Route::get('/app-settings-teams', [TeamMemberController::class, 'index'])->name('team-members.index');
    Route::get('/app-settings-teams/{id}', [TeamMemberController::class, 'index'])->name('team-members.edit');
    Route::post('/app-settings-teams', [TeamMemberController::class, 'store'])->name('team-members.store');
    Route::post('/app-settings-teams-update/{id}', [TeamMemberController::class, 'update'])->name('team-members.update');
    Route::get('/app-settings-teams-delete/{id}', [TeamMemberController::class, 'destroy'])->name('team-members.delete');
    Route::get('/app-settings-teams', [App\Http\Controllers\TeamMemberController::class, 'index'])
        ->name('app.settings.teams');
    Route::get('/team-members/{id}/view', [App\Http\Controllers\TeamMemberController::class, 'view'])->name('team-members.view');

    Route::resource('team-members', TeamMemberController::class);
});

Route::get('/app-settings', function () {
    return view('app-settings');
})->middleware('auth')->name('app.settings');

Route::prefix('posts')->group(function () {

    Route::get('/', [PostController::class, 'index'])->name('posts.index');

    // Create Steps
    Route::get('/create-step1', [PostController::class, 'createStep1'])->name('posts.create.step1');
    Route::post('/store-step1', [PostController::class, 'storeStep1'])->name('posts.store.step1');

    Route::get('/create-step2/{id}', [PostController::class, 'createStep2'])->name('posts.create.step2');
    Route::post('/store-step2/{id}', [PostController::class, 'storeStep2'])->name('posts.store.step2');

    // EDIT
    Route::get('/{id}/edit/step1', [PostController::class, 'editStep1'])->name('posts.edit.step1');
    Route::get('/{id}/edit/step2', [PostController::class, 'editStep2'])->name('posts.edit.step2');

    // UPDATE
Route::post('/{id}/update/step1', [PostController::class, 'updateStep1'])
    ->name('posts.update.step1');

    Route::post('/{id}/update/step2', [PostController::class, 'updateStep2'])->name('posts.update.step2');
Route::delete('/delete/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

});

