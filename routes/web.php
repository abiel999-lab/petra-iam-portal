<?php

use App\Http\Controllers\Auth\SamlAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleSwitchController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SsoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (session()->has('portal_user')) {
        return redirect()->route('dashboard');
    }

    if (session()->has('portal_user_forbidden')) {
        return redirect()->route('sso.forbidden');
    }

    return redirect()->route('login');
})->name('home');

Route::get('/login', [SamlAuthController::class, 'login'])->name('login');
Route::get('/login-force', [SamlAuthController::class, 'reloginForce'])->name('login.force');
Route::post('/logout', [SamlAuthController::class, 'logout'])->name('logout');

Route::get('/sso/forbidden', [SsoController::class, 'forbidden'])->name('sso.forbidden');

Route::middleware(['portal.auth', 'portal.appweb'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/setting', [SettingController::class, 'index'])->name('setting');
    Route::get('/setting/profile', [SettingController::class, 'index'])->name('setting.profile');
    Route::post('/role-switch', RoleSwitchController::class)->name('role.switch');
});
