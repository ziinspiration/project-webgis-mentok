<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Activity;
use App\Services\MailService;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserManager extends Component
{
    public $name, $nip, $email, $selected_id;
    public $isModalOpen = false;
    public $search = '';

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }

    public function mount()
    {
        if (!auth()->user()->is_allaccess) {
            return redirect()->route('dashboard');
        }
    }

    public function openModal()
    {
        $this->reset(['name', 'nip', 'email', 'selected_id']);
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|string|unique:users,nip,' . $this->selected_id,
            'email' => 'required|email|unique:users,email,' . $this->selected_id,
        ]);

        if ($this->selected_id === auth()->id()) {
            $this->dispatch('notify', message: 'Gunakan menu Kelola Akun untuk profil anda', type: 'error');
            return;
        }

        if (!$this->selected_id) {
            $token = Str::random(64);
            $user = User::create([
                'name' => $this->name,
                'nip' => $this->nip,
                'email' => $this->email,
                'password' => Hash::make(Str::random(12)),
                'is_verified' => 0,
                'is_active' => 1,
                'token' => $token
            ]);
            $url = route('setup-password', ['token' => $token]);
            MailService::send(
                $this->email,
                "Aktivasi Akun",
                "Halo <strong>$this->name</strong>, akun anda telah berhasil didaftarkan sebagai administrator. Silakan klik tombol di bawah ini untuk melakukan verifikasi dan pembuatan kata sandi.",
                $url
            );
            $msg = "Pengguna didaftarkan & email terkirim";
            $actionLog = "Menambah";
        } else {
            $user = User::find($this->selected_id);
            $user->update([
                'name' => $this->name,
                'nip' => $this->nip,
                'email' => $this->email
            ]);
            $msg = "Data pengguna berhasil diperbarui";
            $actionLog = "Mengubah Profil";
        }

        Activity::create(['user_name' => auth()->user()->name, 'action' => $actionLog, 'subject' => $this->name, 'type' => 'Pengguna']);
        $this->dispatch('notify', message: $msg, type: 'success');
        $this->closeModal();
    }

    public function toggleStatus($id)
    {
        if ($id === auth()->id()) return;
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();

        Activity::create([
            'user_name' => auth()->user()->name,
            'action' => $user->is_active ? 'Mengaktifkan' : 'Menonaktifkan',
            'subject' => $user->name,
            'type' => 'Pengguna'
        ]);

        $this->dispatch('notify', message: 'Status akun diperbarui', type: 'success');
    }

    public function toggleAccess($id)
    {
        if ($id === auth()->id()) return;
        $user = User::findOrFail($id);
        $user->is_allaccess = !$user->is_allaccess;
        $user->save();

        Activity::create([
            'user_name' => auth()->user()->name,
            'action' => 'Ubah Akses',
            'subject' => $user->name,
            'type' => 'Pengguna'
        ]);

        $this->dispatch('notify', message: 'Hak akses diperbarui', type: 'success');
    }

    public function edit($id)
    {
        if ($id === auth()->id()) return;
        $user = User::findOrFail($id);
        $this->selected_id = $id;
        $this->name = $user->name;
        $this->nip = $user->nip;
        $this->email = $user->email;
        $this->isModalOpen = true;
    }

    #[Layout('layouts.apps')]
    public function render()
    {
        return view('livewire.admin.user-manager', [
            'users' => User::where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('nip', 'like', '%' . $this->search . '%');
            })->latest()->get()
        ]);
    }
}