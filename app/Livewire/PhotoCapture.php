<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class PhotoCapture extends Component
{

    public $photo = [];
    public $id = 0;

    public function addPhoto($frame){
        $this->photo[$this->id] = $frame;
        $this->id++;
    }

    public function download(){
    }

    public function render()
    {
        return view('livewire.photo-capture');
    }

}
