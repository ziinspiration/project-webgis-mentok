<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class Login extends Component
{
    public $nip = '';
    public $password = '';
    public $showPassword = false;

    public function togglePassword()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function login()
    {
        $this->validate(['nip' => 'required', 'password' => 'required']);

        $throttleKey = Str::lower($this->nip) . '|' . request()->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $this->dispatch('login-failed', message: 'Terlalu banyak percobaan. Coba lagi nanti.');
            return;
        }

        if (Auth::attempt([
            'nip' => $this->nip,
            'password' => $this->password,
            'is_active' => 1,
            'is_verified' => 1
        ])) {
            RateLimiter::clear($throttleKey);
            session()->regenerate();
            return redirect()->intended('dashboard');
        }

        RateLimiter::hit($throttleKey);
        $this->dispatch('login-failed', message: 'Akses ditolak. NIP/Sandi salah atau akun tidak aktif.');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.auth.login');
    }
}