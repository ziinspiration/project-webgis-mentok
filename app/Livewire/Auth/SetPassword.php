<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Models\Activity;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SetPassword extends Component
{
    public $token, $password, $password_confirmation;

    public function mount($token)
    {
        $this->token = $token;
        if (!User::where('token', $token)->exists()) {
            return redirect()->route('login');
        }
    }

    public function submit()
    {
        $this->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('token', $this->token)->first();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->password && Hash::check($this->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => 'Password baru tidak boleh sama dengan password lama.'
            ]);
        }

        $user->update([
            'password' => Hash::make($this->password),
            'is_verified' => 1,
            'is_active' => 1,
            'token' => null
        ]);

        Activity::create([
            'user_name' => $user->name,
            'action' => 'Memperbarui',
            'subject' => 'Kata Sandi Akun',
            'type' => 'Keamanan'
        ]);

        if (Auth::check()) {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
        }

        return redirect()->route('login')->with('status', 'Berhasil! Akun anda telah aktif. Silakan login dengan kata sandi baru.');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.auth.set-password');
    }
}