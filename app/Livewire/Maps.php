<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

class Maps extends Component
{
    public $showSidebar = false;
    public $activeLayer = 'satellite';

    public function toggleSidebar()
    {
        $this->showSidebar = !$this->showSidebar;
    }

    public function setLayer($layer)
    {
        $this->activeLayer = $layer;
        $this->dispatch('layer-changed', layer: $layer);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.maps');
    }
}
