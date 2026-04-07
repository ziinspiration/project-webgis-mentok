<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Activity;
use App\Services\MailService;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Profile extends Component
{
    public $name, $nip, $email;

    public function mount()
    {
        $this->name = auth()->user()->name;
        $this->nip = auth()->user()->nip;
        $this->email = auth()->user()->email;
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|string|unique:users,nip,' . auth()->id(),
            'email' => 'required|email|unique:users,email,' . auth()->id(),
        ]);

        $user = User::find(auth()->id());
        $user->update([
            'name' => $this->name,
            'nip' => $this->nip,
            'email' => $this->email,
        ]);

        Activity::create(['user_name' => $this->name, 'action' => 'Mengubah', 'subject' => 'Profil Pribadi', 'type' => 'Keamanan']);
        $this->dispatch('notify', message: 'Profil berhasil diperbarui', type: 'success');
    }

    public function requestPasswordChange()
    {
        $user = auth()->user();
        $token = Str::random(64);
        $user->update(['token' => $token]);
        $url = route('setup-password', ['token' => $token]);

        MailService::send(
            $user->email,
            "Konfirmasi Ganti Password",
            "Kami menerima permintaan perubahan kata sandi dari profil anda. Klik tombol di bawah ini untuk memverifikasi tindakan ini demi keamanan akun anda.",
            $url
        );
        $this->dispatch('notify', message: 'Link verifikasi dikirim ke email anda', type: 'success');
    }

    #[Layout('layouts.apps')]
    public function render()
    {
        return view('livewire.admin.profile');
    }
}