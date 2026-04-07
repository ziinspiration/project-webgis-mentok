<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Services\MailService;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Str;

class ForgotPassword extends Component
{
    public $email;

    public function submit()
    {
        $this->validate(['email' => 'required|email']);

        $user = User::where('email', $this->email)->first();

        if ($user) {
            $token = Str::random(64);
            $user->update(['token' => $token]);

            $url = route('setup-password', ['token' => $token]);

            MailService::send(
                $this->email,
                "Pemulihan Kata Sandi",
                "Anda meminta pemulihan kata sandi untuk akun di sistem kami. Silakan klik tombol di bawah ini untuk mengatur ulang kata sandi anda. Link ini berlaku untuk satu kali penggunaan.",
                $url
            );
        }

        $this->reset('email');
        session()->flash('status', 'Jika email terdaftar, tautan pemulihan telah dikirim.');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}