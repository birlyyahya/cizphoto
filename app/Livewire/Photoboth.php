<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use PragmaRX\Google2FAQRCode\Google2FA;


class Photoboth extends Component
{
    use WithFileUploads;

    public $photoData = [];
    public $currentPhotoIndex = 0;
    public $photoSaved = false;
    public $savedPhotos = [];
    public $timerActive = false;
    public $timerCount = 3; // Hitungan mundur awal


    public function addPhoto($photoData)
    {
        if ($this->currentPhotoIndex < 3) {
            $this->photoData[$this->currentPhotoIndex] = $photoData;
            $this->currentPhotoIndex++;
        }
    }

    public function resetPhotos()
    {
        $this->photoData = [];
        $this->currentPhotoIndex = 0;
        $this->photoSaved = false;
        $this->timerActive = false;
    }

    public function startTimer()
    {
        $this->timerActive = true;
        $this->dispatch('startCountdown');
    }

    public function savePhotos()
    {
        $this->savedPhotos = [];

        // Simpan semua foto
        foreach ($this->photoData as $index => $photoData) {
            if ($photoData) {
                $image = substr($photoData, strpos($photoData, ',') + 1);
                $image = base64_decode($image);

                // Generate nama file unik
                $filename = 'profile-photo-' . auth()->id() . '-' . time() . '-' . $index . '.png';

                // Simpan gambar
                Storage::disk('public')->put('profile-photos/' . $filename, $image);

                $this->savedPhotos[] = $filename;
            }
        }
        $this->photoSaved = true;
        $this->emit('photosSaved', $this->savedPhotos);
    }
    public function render()
    {

    // $google2fa = new Google2FA();

    // $key = $google2fa->generateSecretKey();
    // $qrCode = $google2fa->getQRCodeInline("example", "example", $key);

        return view('livewire.photoboth',[
            // 'qrCode' => $qrCode
        ]);
    }
}
