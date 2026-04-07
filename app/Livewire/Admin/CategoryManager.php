<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Activity;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CategoryManager extends Component
{
    public $name, $selected_id;
    public $isModalOpen = false;

    protected $rules = [
        'name' => 'required|string|min:3|max:255',
    ];

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }

    public function updateOrder($items)
    {
        foreach ($items as $item) {
            Category::where('id', $item['value'])->update(['sort_order' => $item['order']]);
        }
        $this->dispatch('notify', message: 'Urutan Kategori Berhasil Diperbarui', type: 'success');
    }

    public function openModal()
    {
        $this->reset(['name', 'selected_id']);
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function save()
    {
        $this->validate();
        $action = $this->selected_id ? 'Mengubah' : 'Menambah';

        if (!$this->selected_id) {
            $lastOrder = Category::max('sort_order') ?? 0;
            Category::create([
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'sort_order' => $lastOrder + 1
            ]);
        } else {
            Category::where('id', $this->selected_id)->update([
                'name' => $this->name,
                'slug' => Str::slug($this->name),
            ]);
        }

        Activity::create([
            'user_name' => auth()->user()->name,
            'action' => $action,
            'subject' => $this->name,
            'type' => 'Kategori'
        ]);

        $this->dispatch('notify', message: "Kategori Berhasil $action", type: 'success');
        $this->closeModal();
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->selected_id = $id;
        $this->name = $category->name;
        $this->isModalOpen = true;
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        Activity::create([
            'user_name' => auth()->user()->name,
            'action' => 'Menghapus',
            'subject' => $category->name,
            'type' => 'Kategori'
        ]);
        $category->delete();
        $this->dispatch('notify', message: 'Kategori dihapus', type: 'error');
    }

    #[Layout('layouts.apps')]
    public function render()
    {
        return view('livewire.admin.category-manager', [
            'categories' => Category::orderBy('sort_order', 'asc')->get()
        ]);
    }
}