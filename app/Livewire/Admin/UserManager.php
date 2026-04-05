<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Activity;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;

class UserManager extends Component
{
    public $name, $nip, $email, $selected_id;
    public $isModalOpen = false;
    public $search = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'nip' => 'required|string|unique:users,nip',
        'email' => 'required|email|unique:users,email',
    ];

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
        $rules = $this->rules;
        if ($this->selected_id) {
            $rules['nip'] = 'required|string|unique:users,nip,' . $this->selected_id;
            $rules['email'] = 'required|email|unique:users,email,' . $this->selected_id;
        }

        $this->validate($rules);

        if (!$this->selected_id) {
            $user = User::create([
                'name' => $this->name,
                'nip' => $this->nip,
                'email' => $this->email,
                'password' => bcrypt(Str::random(16)),
            ]);

            Password::sendResetLink(['email' => $this->email]);
            $msg = 'Pengguna Berhasil Ditambahkan & Email Aktivasi Terkirim';
        } else {
            $user = User::find($this->selected_id);
            $user->update([
                'name' => $this->name,
                'nip' => $this->nip,
                'email' => $this->email,
            ]);
            $msg = 'Data Pengguna Berhasil Diperbarui';
        }

        Activity::create([
            'user_name' => auth()->user()->name,
            'action' => $this->selected_id ? 'Mengubah' : 'Menambah',
            'subject' => $this->name,
            'type' => 'Pengguna'
        ]);

        $this->dispatch('notify', message: $msg, type: 'success');
        $this->closeModal();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->selected_id = $id;
        $this->name = $user->name;
        $this->nip = $user->nip;
        $this->email = $user->email;
        $this->isModalOpen = true;
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        if ($user->id === auth()->id()) {
            $this->dispatch('notify', message: 'Tidak dapat menghapus akun sendiri!', type: 'error');
            return;
        }

        Activity::create([
            'user_name' => auth()->user()->name,
            'action' => 'Menghapus',
            'subject' => $user->name,
            'type' => 'Pengguna'
        ]);

        $user->delete();
        $this->dispatch('notify', message: 'Pengguna Berhasil Dihapus', type: 'error');
    }

    #[Layout('layouts.apps')]
    public function render()
    {
        return view('livewire.admin.user-manager', [
            'users' => User::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('nip', 'like', '%' . $this->search . '%')
                ->latest()->get()
        ]);
    }
}