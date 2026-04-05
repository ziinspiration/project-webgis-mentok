<?php

use App\Livewire\Dashboard;
use App\Livewire\Auth\Login;
use App\Livewire\Maps;
use App\Livewire\Admin\CategoryManager;
use App\Livewire\Admin\MapDataManager;
use App\Livewire\Admin\UserManager;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', Maps::class)->name('home');

Route::get('/login', Login::class)->name('login')->middleware('guest');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/categories', CategoryManager::class)->name('categories');
    Route::get('/map-data', MapDataManager::class)->name('map-data');
    Route::get('/users', UserManager::class)->name('users');
    Route::post('/logout', function () {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');
});