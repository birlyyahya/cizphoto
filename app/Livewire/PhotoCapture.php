<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class PhotoCapture extends Component
{

    public $photo = [];
    public $id = 0;

    public function mount()
    {

        $this->photo = [];
        $this->id = 0;
        // Bersihkan session lama jika ada
        // $this->cleanupOldSessions();
    }

    // private function cleanupOldSessions()
    // {
    //     // Hapus semua session key yang mengandung 'photo_'
    //     $keys = collect(session()->all())->keys()
    //         ->filter(function($key) {
    //             return strpos($key, 'photo_') === 0;
    //         });

    //     foreach($keys as $key) {
    //         session()->forget($key);
    //     }
    // }

    // public function dehydrate()
    // {
    //     // Ini akan dipanggil sebelum komponen di-render
    //     // dan dapat memastikan session konsisten
    //     session()->save();
    // }

    #[lazy]
    public function addPhoto($frame){
        $timestamp = time();
        // session()->put("photo_{$this->id}_{$timestamp}", $frame);

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
