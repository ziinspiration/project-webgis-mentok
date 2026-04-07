<?php

use App\Livewire\Admin\CategoryManager;
use App\Livewire\Admin\MapDataManager;
use App\Livewire\Admin\Profile;
use App\Livewire\Admin\UserManager;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\SetPassword;
use App\Livewire\Dashboard;
use App\Livewire\Maps;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', Maps::class)->name('home');

Route::get('/login', Login::class)->name('login')->middleware('guest');
Route::get('/forgot-password', ForgotPassword::class)->name('forgot-password')->middleware('guest');
Route::get('/setup-password/{token}', SetPassword::class)->name('setup-password');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/categories', CategoryManager::class)->name('categories');
    Route::get('/map-data', MapDataManager::class)->name('map-data');
    Route::get('/users', UserManager::class)->name('users');
    Route::get('/profile', Profile::class)->name('profile');
    Route::post('/logout', function () {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');
});