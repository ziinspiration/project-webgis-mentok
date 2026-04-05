<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class Login extends Component
{
    public $nip = '';
    public $password = '';
    public $showPassword = false;

    public function togglePassword()
    {
        $this->showPassword = !$this->showPassword;
    }

    protected function throttleKey()
    {
        return Str::lower($this->nip) . '|' . request()->ip();
    }

    public function login()
    {
        $this->validate([
            'nip' => 'required|string',
            'password' => 'required|string',
        ]);

        if (RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            $seconds = RateLimiter::availableIn($this->throttleKey());

            $this->dispatch(
                'login-failed',
                message: "Terlalu banyak percobaan. Silakan coba lagi dalam $seconds detik."
            );
            return;
        }

        if (Auth::attempt(['nip' => $this->nip, 'password' => $this->password])) {
            RateLimiter::clear($this->throttleKey());

            session()->regenerate();

            return redirect()->intended('dashboard');
        }

        RateLimiter::hit($this->throttleKey(), 60);

        $this->dispatch(
            'login-failed',
            message: 'NIP atau Kata Sandi yang anda masukkan tidak terdaftar di sistem kami.'
        );
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.auth.login');
    }
}