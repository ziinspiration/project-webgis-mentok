<?php

namespace App\Livewire\Admin;

use App\Models\MapData;
use App\Models\Category;
use App\Models\Activity;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;

class MapDataManager extends Component
{
    use WithFileUploads;

    public $name, $category_id, $type = 'Polygon', $geojson_file, $icon_file, $selected_id;
    public $isModalOpen = false;

    public $search = '';
    public $filterCategory = '';
    public $filterType = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'type' => 'required|in:Point,Line,Polygon',
        'geojson_file' => 'nullable|file|mimes:json,geojson|max:10240',
        'icon_file' => 'nullable|image|max:1024',
    ];

    public function openModal()
    {
        $this->reset(['name', 'category_id', 'type', 'geojson_file', 'icon_file', 'selected_id']);
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function save()
    {
        $this->validate($this->selected_id ? array_merge($this->rules, ['geojson_file' => 'nullable']) : $this->rules);

        $action = $this->selected_id ? 'Mengubah' : 'Menambah';

        $data = [
            'name' => $this->name,
            'category_id' => $this->category_id,
            'type' => $this->type,
        ];

        if ($this->geojson_file) {
            $data['geojson_path'] = $this->geojson_file->store('geojson', 'public');
        }

        if ($this->type === 'Point' && $this->icon_file) {
            $data['icon_path'] = $this->icon_file->store('icons', 'public');
        }

        MapData::updateOrCreate(['id' => $this->selected_id], $data);

        Activity::create([
            'user_name' => auth()->user()->name,
            'action' => $action,
            'subject' => $this->name,
            'type' => 'Data Spasial'
        ]);

        $this->dispatch('notify', message: "Data Spasial Berhasil $action", type: 'success');
        $this->closeModal();
    }

    public function edit($id)
    {
        $map = MapData::findOrFail($id);
        $this->selected_id = $id;
        $this->name = $map->name;
        $this->category_id = $map->category_id;
        $this->type = $map->type;
        $this->isModalOpen = true;
    }

    public function delete($id)
    {
        $map = MapData::findOrFail($id);

        Activity::create([
            'user_name' => auth()->user()->name,
            'action' => 'Menghapus',
            'subject' => $map->name,
            'type' => 'Data Spasial'
        ]);

        if ($map->geojson_path) Storage::disk('public')->delete($map->geojson_path);
        if ($map->icon_path) Storage::disk('public')->delete($map->icon_path);

        $map->delete();
        $this->dispatch('notify', message: 'Data Berhasil Dihapus', type: 'error');
    }

    #[Layout('layouts.apps')]
    public function render()
    {
        $query = MapData::with('category')->latest();

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->filterCategory) {
            $query->where('category_id', $this->filterCategory);
        }

        if ($this->filterType) {
            $query->where('type', $this->filterType);
        }

        return view('livewire.admin.map-data-manager', [
            'allData' => $query->get(),
            'categories' => Category::orderBy('sort_order', 'asc')->get()
        ]);
    }
}