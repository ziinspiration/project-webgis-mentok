<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\MapData;
use App\Models\Activity;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }

    #[Layout('layouts.apps')]
    public function render()
    {
        return view('livewire.dashboard', [
            'user' => Auth::user(),
            'stats' => [
                ['label' => 'Data Polygon', 'value' => MapData::where('type', 'Polygon')->count(), 'icon' => 'polygon', 'color' => 'purple'],
                ['label' => 'Data Line', 'value' => MapData::where('type', 'Line')->count(), 'icon' => 'line', 'color' => 'orange'],
                ['label' => 'Data Point', 'value' => MapData::where('type', 'Point')->count(), 'icon' => 'point', 'color' => 'emerald'],
                ['label' => 'Total Pengguna', 'value' => User::count(), 'icon' => 'users', 'color' => 'blue'],
            ],
            'recentActivities' => Activity::latest()->limit(15)->get(),
            'allMapData' => MapData::all()
        ]);
    }
}