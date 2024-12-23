<?php

namespace App\Livewire\Fans;

use Livewire\Component;

class IndexFans extends Component
{
        public $cosplayerId;
    public $cosplayerName;

    public function mount($cosplayerId, $cosplayerName)
    {
        $this->cosplayerId = $cosplayerId;
        $this->cosplayerName = $cosplayerName;
    }
    public function render()
    {
        return view('livewire.fans.index-fans');
    }
}
