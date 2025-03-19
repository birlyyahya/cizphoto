<div>
    <div class="flex flex-col md:flex-row gap-6     ">
        <!-- Camera Preview Section -->
        <div class="flex-1 justify-center">
            <div class="relative justify-items-center">
                <video id="video" autoplay class="w-[640px] h-[480px] object-cover bg-gray-100 rounded-lg shadow-inner -scale-x-100"></video>

                <div id="timerOverlay" class="absolute inset-0 flex items-center justify-center hidden">
                    <div class="text-white text-9xl font-bold" id="timerDisplay">3</div>
                </div>
            </div>
            <div class="mt-4 flex justify-center space-x-4">
                <flux:button icon="camera" id="takePhotoButton" variant="primary" onclick="takePhotoWithCapture(event)">
                    Take a Cizz!
                </flux:button>

            </div>
        </div>

        <!-- Photo Result Section -->
        <div class="flex-0 justify-center">
            <div class="relative flex-row space-y-1 justify-items-center">
                <canvas id="takePhotoCanvas1" wire:ignore class="w-48 h-36 object-cover bg-gray-100 rounded-lg shadow-inner"></canvas>
                <canvas id="takePhotoCanvas2" wire:ignore class="w-48 h-36 object-cover bg-gray-100 rounded-lg shadow-inner"></canvas>
                <canvas id="takePhotoCanvas3" wire:ignore class="w-48 h-36 object-cover bg-gray-100 rounded-lg shadow-inner"></canvas>
            </div>
            <div class="mt-4 text-center">
                <flux:modal.trigger name="next" class="" id="nextStep">
                    <flux:button variant="primary">Next</flux:button>
                </flux:modal.trigger>

                <flux:modal name="next" class="w-2/3 md:w-full max-w-2xl max-h-screen bg-zinc-200 gap-5">
                    <div x-data="{ frameColor: '#000' }" class="grid grid-cols-1 md:grid-cols-2 h-full gap-5">
                        <div class="frame mb-2 flex flex-col order-last md:order-first gap-5">
                            <label class="color-picker flex items-center border bg-white rounded-lg px-2 py-1 border-slate-300 gap-3">
                                <input type="color" style="border-radius: 100%;" x-model="frameColor" :value="frameColor" class="h-8 w-8 block cursor-pointer disabled:opacity-50 disabled:pointer-events-none" id="colorinput" title="Choose your color">
                                <label for="colorinput" class="">Pilih Warna</label>
                            </label>
                            <div class="template-color space-y-2 gap-2 mt-2">
                                <x-partials.radioColor>
                                </x-partials.radioColor>
                            </div>
                            <div class="flex grow-1 gap-5 mt-5 p-10 md:m-0 md:p-0 md:justify-normal justify-center">
                                <flux:button id="downloadPhoto" @click="downloadImage(event)" variant="primary" class="self-end">Download</flux:button>
                                <flux:button class="self-end">Send Email</flux:button>
                            </div>
                        </div>
                        <div id="framePhotobooth" class="space-y-2 flex flex-col w-fit p-5 m-auto items-center" :class="`bg-${frameColor}-500`" :style="{ backgroundColor: frameColor }">
                            {{-- @foreach ($this->photo as $key => $value ) --}}
                            <div class="relative">
                                <canvas id="previewDownload1" class="w-48 h-36 object-cover bg-gray-100 rounded-lg shadow-inner"></canvas>
                                <div class="absolute inset-0 flex">
                                    {{-- <img src="{{ $value }}" class="w-48 h-36 object-cover shadow-inner" loading="lazy"> --}}
                                </div>
                            </div>
                            <div class="relative">
                                <canvas id="previewDownload2" class="w-48 h-36 object-cover bg-gray-100 rounded-lg shadow-inner"></canvas>
                                <div class="absolute inset-0 flex">
                                    {{-- <img src="{{ $value }}" class="w-48 h-36 object-cover shadow-inner" loading="lazy"> --}}
                                </div>
                            </div>
                            <div class="relative">
                                <canvas id="previewDownload3" class="w-48 h-36 object-cover bg-gray-100 rounded-lg shadow-inner"></canvas>
                                <div class="absolute inset-0 flex">
                                    {{-- <img src="{{ $value }}" class="w-48 h-36 object-cover shadow-inner" loading="lazy"> --}}
                                </div>
                            </div>
                            {{-- @endforeach --}}
                            <h1 class="text-center text-xs" :class="frameColor === '#ffffff' ? 'text-black' : 'text-white'" :style="{ backgroundColor: frameColor }">
                                🎀 Cizzphoto 🎀
                            </h1>
                        </div>
                    </div>
                </flux:modal>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/html2canvas-pro@1.5.8/dist/html2canvas-pro.min.js"></script>
<script>
    let imageCapture = null;
    let mediaStream = null;
    let currentPhotoIndex = 0;



    navigator.mediaDevices.getUserMedia({
            video: true
        })
        .then(stream => {
            mediaStream = stream;
            const videoElement = document.getElementById('video');
            videoElement.srcObject = stream;

            const track = stream.getVideoTracks()[0];
            imageCapture = new ImageCapture(track);
        })
        .catch(error => console.error("Error accessing camera:", error));

    function takePhotoWithCapture(e) {
        e.preventDefault();
        if (!imageCapture) return console.error("Camera not initialized");

        imageCapture.grabFrame()
            .then(imageBitmap => {
                const canvas = document.getElementById('takePhotoCanvas' + currentPhotoIndex);
                const preview = document.getElementById('previewDownload' + currentPhotoIndex);
                drawMirroredCanvas(canvas, imageBitmap, preview);
                // @this.call('addPhoto', canvas.toDataURL('image/png'));
            })
            .catch(error => console.error("Error taking photo:", error));

        currentPhotoIndex++;
        timerOverlay.classList.add('hidden');
    }

    function runSquencePhoto(e) {
        e.preventDefault();
        document.getElementById('takePhotoButton').setAttribute('disabled', 'true');
        if (!imageCapture) return console.error("Camera not initialized");

        // Jika sudah mencapai batas foto, langsung keluar
        if (currentPhotoIndex >= 3) {
            return;
        }

        let count = 3; // Hitungan mundur

        timerOverlay.classList.remove('hidden');
        timerDisplay.textContent = count;

        const countdownInterval = setInterval(() => {
            count--;
            timerDisplay.textContent = count;

            if (count === 0) {
                clearInterval(countdownInterval);

                // Ambil foto saat hitungan mencapai 0
                takePhotoWithCapture(e);
                console.log(currentPhotoIndex);

                // Jika masih ada foto yang perlu diambil, lanjutkan
                setTimeout(() => {
                    if (currentPhotoIndex < 3) {
                        runSquencePhoto(e);
                    } else {
                        document.getElementById('nextStep').classList.remove('hidden');
                        document.getElementById('takePhotoButton').setAttribute('disabled', 'true');
                        timerOverlay.classList.add('hidden');
                    }
                }, 500);
            }
        }, 1000);
    }

    function drawMirroredCanvas(canvas, img, preview) {
        const ctx = canvas.getContext('2d');
        const cty = preview.getContext('2d');

        canvas.width = img.width;
        canvas.height = img.height;


        ctx.save();
        ctx.translate(canvas.width, 0);
        ctx.scale(-1, 1);

        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
        ctx.restore();

        preview.width = img.width;
        preview.height = img.height;


        cty.save();
        cty.translate(canvas.width, 0);
        cty.scale(-1, 1);

        cty.drawImage(img, 0, 0, preview.width, preview.height);
        cty.restore();
    }

    function downloadImage(e) {
        e.preventDefault();
        const element = document.getElementById('framePhotobooth');

        html2canvas(element).then(function(canvas) {
            const imageURL = canvas.toDataURL('image/png');

            // Buat elemen link baru untuk download
            const downloadLink = document.createElement('a');
            downloadLink.href = imageURL;
            downloadLink.download = 'Cizzphoto.png';

            document.body.appendChild(downloadLink);

            downloadLink.click();

            document.body.removeChild(downloadLink);

        }).catch(function(error) {
            console.error('Error capturing image:', error);
        });
    }

</script>
@endpush
