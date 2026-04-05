<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\MapData;
use Livewire\Attributes\Layout;

class Maps extends Component
{
    public $showSidebar = false;
    public $activeLayer = 'satellite';
    public $activeGeojsons = []; // Menyimpan ID data yang sedang ON

    public function toggleSidebar()
    {
        $this->showSidebar = !$this->showSidebar;
    }

    public function setLayer($layer)
    {
        $this->activeLayer = $layer;
        $this->dispatch('layer-changed', layer: $layer);
    }

    public function toggleGeojson($id)
    {
        $data = MapData::find($id);
        if (!$data) return;

        if (in_array($id, $this->activeGeojsons)) {
            $this->activeGeojsons = array_diff($this->activeGeojsons, [$id]);
            // Beritahu JS untuk menghapus layer
            $this->dispatch('remove-layer', id: $id);
        } else {
            $this->activeGeojsons[] = $id;
            // Beritahu JS untuk menambah layer
            $this->dispatch(
                'add-layer',
                id: $id,
                path: asset('storage/' . $data->geojson_path),
                type: $data->type,
                icon: $data->icon_path ? asset('storage/' . $data->icon_path) : null
            );
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.maps', [
            'categories' => Category::with('mapData')->orderBy('sort_order', 'asc')->get()
        ]);
    }
}