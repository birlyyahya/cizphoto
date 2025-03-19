<div>
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Camera Preview Section -->
        <div class="flex-1 justify-center">
            <div class="relative justify-items-center">
                <video id="video" autoplay class="w-[320px] h-[180px] md:w-[640px] md:h-[480px]
                       object-cover bg-gray-100 rounded-lg shadow-inner -scale-x-100">
                </video>
                <div id="countDisplay" class="absolute inset-0 flex items-center justify-center hidden">
                    <div class="text-white text-9xl font-bold" id="timerDisplay">3</div>
                </div>
                <div id="timerOverlay" class="absolute inset-0 bg-black flex items-center justify-center hidden">
                </div>
            </div>
            <div class="mt-4 flex justify-center space-x-4">
                <flux:button icon="camera" id="takePhotoButton" variant="primary" onclick="runSquencePhoto(event)">
                    Take a Cizz!
                </flux:button>
                <flux:button icon="camera" style="display:none;" id="resetButton" onclick="resetPhotos(event)">
                    Retake
                </flux:button>
                <div class="flex">
                    <flux:select id="countSelector" placeholder="">
                        <flux:select.option value="3">3</flux:select.option>
                        <flux:select.option value="5">5</flux:select.option>
                        <flux:select.option value="10">10</flux:select.option>
                    </flux:select>
                </div>
            </div>
        </div>

        <!-- Photo Result Section -->
        <div class="flex-0 justify-center">
            <div class="relative flex-row space-y-1 justify-items-center">
                <canvas id="takePhotoCanvas1" wire:ignore class="w-40 h-30 sm:w-48 sm:h-36 object-cover bg-gray-100 rounded-lg shadow-inner">
                </canvas>
                <canvas id="takePhotoCanvas2" wire:ignore class="w-40 h-30 sm:w-48 sm:h-36 object-cover bg-gray-100 rounded-lg shadow-inner"></canvas>
                <canvas id="takePhotoCanvas3" wire:ignore class="w-40 h-30 sm:w-48 sm:h-36 object-cover bg-gray-100 rounded-lg shadow-inner"></canvas>
            </div>
            <div class="mt-4 text-center">
                <flux:modal.trigger name="next" class="hidden" id="nextStep">
                    <flux:button variant="primary">Next</flux:button>
                </flux:modal.trigger>

                <flux:modal name="next" class="w-3/4 h-4/5 md:w-full max-w-2xl max-h-screen bg-zinc-200 gap-5">
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
                        <div id="framePhotobooth" class="space-y-2 flex flex-col w-full md:w-fit p-5 m-auto md:justify-normal  items-center" :class="`bg-${frameColor}-500`" :style="{ backgroundColor: frameColor }">
                            {{-- @foreach ($this->photo as $key => $value ) --}}
                            <div class="relative">
                                <canvas id="previewDownload1" class="w-48 h-36 object-cover bg-gray-100  shadow-inner"></canvas>
                                <div class="absolute inset-0 flex">
                                    {{-- <img src="{{ $value }}" class="w-48 h-36 object-cover shadow-inner" loading="lazy"> --}}
                                </div>
                            </div>
                            <div class="relative">
                                <canvas id="previewDownload2" class="w-48 h-36 object-cover bg-gray-100  shadow-inner"></canvas>
                                <div class="absolute inset-0 flex">
                                    {{-- <img src="{{ $value }}" class="w-48 h-36 object-cover shadow-inner" loading="lazy"> --}}
                                </div>
                            </div>
                            <div class="relative">
                                <canvas id="previewDownload3" class="w-48 h-36 object-cover bg-gray-100  shadow-inner"></canvas>
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
    let currentPhotoIndex = 1;
    let countDown = 3;
    document.getElementById('countSelector').addEventListener('change', function(event) {
        countDown = parseInt(event.target.value); // Ubah nilai count
    });
    // Inisialisasi kamera saat halaman dimuat
    document.addEventListener('DOMContentLoaded', initCamera);

    function initCamera() {
        navigator.mediaDevices.getUserMedia({
                video: true
            })
            .then(stream => {
                mediaStream = stream;
                const videoElement = document.getElementById('video');
                videoElement.srcObject = stream;

                const track = stream.getVideoTracks()[0];

                // Check if ImageCapture is supported
                if (typeof ImageCapture !== 'undefined') {
                    // Chrome and supported browsers
                    imageCapture = new ImageCapture(track);
                }
                // Untuk Safari, kita akan menggunakan videoElement langsung
            })
            .catch(error => console.error("Error accessing camera:", error));
    }

    function takePhotoWithCapture(e) {
        if (e) e.preventDefault();

        const videoElement = document.getElementById('video');
        const canvas = document.getElementById('takePhotoCanvas' + currentPhotoIndex);
        const preview = document.getElementById('previewDownload' + currentPhotoIndex);

        if (typeof ImageCapture !== 'undefined' && imageCapture) {
            // Untuk Chrome dan browser yang mendukung ImageCapture
            imageCapture.grabFrame()
                .then(imageBitmap => {
                    drawMirroredCanvas(canvas, imageBitmap, preview);
                })
                .catch(error => {
                    console.error("Error taking photo with ImageCapture:", error);
                    // Fallback ke metode canvas jika ImageCapture gagal
                    captureFromVideo(videoElement, canvas, preview);
                });
        } else {
            // Fallback untuk Safari - gunakan canvas untuk menangkap dari video
            captureFromVideo(videoElement, canvas, preview);
        }

        setTimeout(() => {
            if (countDisplay) countDisplay.classList.add('hidden');
            if (timerOverlay) timerOverlay.classList.add('hidden');
        }, 100);

        currentPhotoIndex++;
    }

    function captureFromVideo(videoElement, canvas, preview) {
        if (!videoElement || !canvas) return console.error("Video or canvas element not found");

        const ctx = canvas.getContext('2d');

        // Set canvas dimensions to match video
        canvas.width = videoElement.videoWidth;
        canvas.height = videoElement.videoHeight;

        // Draw mirrored video frame on canvas
        ctx.save();
        ctx.translate(canvas.width, 0);
        ctx.scale(-1, 1);
        ctx.drawImage(videoElement, 0, 0, canvas.width, canvas.height);
        ctx.restore();

        // Do the same for preview if it exists
        if (preview) {
            const cty = preview.getContext('2d');
            preview.width = videoElement.videoWidth;
            preview.height = videoElement.videoHeight;

            cty.save();
            cty.translate(preview.width, 0);
            cty.scale(-1, 1);
            cty.drawImage(videoElement, 0, 0, preview.width, preview.height);
            cty.restore();
        }
    }

    function runSquencePhoto(e) {
        if (e) e.preventDefault();
        const takePhotoButton = document.getElementById('takePhotoButton');
        document.getElementById('countSelector').setAttribute('disabled', true);
        const timerDisplay = document.getElementById('timerDisplay');
        const countDisplay = document.getElementById('countDisplay');
        const timerOverlay = document.getElementById('timerOverlay');

        takePhotoButton.setAttribute('disabled', 'true');

        // Periksa ketersediaan kamera
        if (!mediaStream) {
            console.error("Camera not initialized");
            initCamera(); // Coba inisialisasi ulang kamera
            setTimeout(() => runSquencePhoto(e), 1000); // Coba ulang sequence setelah 1 detik
            return;
        }

        // Jika sudah mencapai batas foto, langsung keluar
        if (currentPhotoIndex > 3) {
            return;
        }

        let count = countDown;
        timerDisplay.textContent = count;
        takePhotoButton.textContent = 'Get Ready!';
        countDisplay.classList.remove('hidden');

        const countdownInterval = setInterval(() => {
            count--;
            timerDisplay.textContent = count;
            takePhotoButton.textContent = 'Standby!';

            if (count === 0) {
                takePhotoButton.textContent = 'Cizz!';
                timerOverlay.classList.remove('hidden');
                clearInterval(countdownInterval);

                // Ambil foto saat hitungan mencapai 0
                takePhotoWithCapture(e);

                // Jika masih ada foto yang perlu diambil, lanjutkan
                setTimeout(() => {
                    if (currentPhotoIndex <= 3) {
                        runSquencePhoto(e);
                    } else {
                        document.getElementById('nextStep').classList.remove('hidden');
                        takePhotoButton.style.display = 'none';
                        document.getElementById('resetButton').style.display = 'flex';
                        takePhotoButton.setAttribute('disabled', 'true');
                        timerOverlay.classList.add('hidden');
                        takePhotoButton.textContent = 'Retake';
                    }
                }, 500);
            }
        }, 1000);
    }

    function drawMirroredCanvas(canvas, img, preview) {
        if (!canvas || !img) return console.error("Canvas or image not available");

        const ctx = canvas.getContext('2d');
        canvas.width = img.width || img.videoWidth || 640;
        canvas.height = img.height || img.videoHeight || 480;

        ctx.save();
        ctx.translate(canvas.width, 0);
        ctx.scale(-1, 1);
        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
        ctx.restore();

        // Handle preview canvas if provided
        if (preview) {
            const cty = preview.getContext('2d');
            preview.width = canvas.width;
            preview.height = canvas.height;

            cty.save();
            cty.translate(preview.width, 0);
            cty.scale(-1, 1);
            cty.drawImage(img, 0, 0, preview.width, preview.height);
            cty.restore();
        }
    }

    function downloadImage(e) {
        if (e) e.preventDefault();
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

    function resetPhotos(e) {
        if (e) e.preventDefault();

        // Reset counter dan status
        currentPhotoIndex = 1;

        // Reset tombol dan elemen UI
        const takePhotoButton = document.getElementById('takePhotoButton');
        if (takePhotoButton) {
            takePhotoButton.removeAttribute('disabled');
            takePhotoButton.textContent = 'Take Photo';
        }
        takePhotoButton.style.display = 'flex';
        document.getElementById('resetButton').style.display = 'none';
        document.getElementById('countSelector').removeAttribute('disabled');
        // Sembunyikan tombol next step
        const nextStep = document.getElementById('nextStep');
        if (nextStep) {
            nextStep.classList.add('hidden');
        }

        // Reset semua canvas
        for (let i = 0; i <= 3; i++) {
            const canvas = document.getElementById('takePhotoCanvas' + i);
            const preview = document.getElementById('previewDownload' + i);

            if (canvas) {
                const ctx = canvas.getContext('2d');
                ctx.clearRect(0, 0, canvas.width, canvas.height);
            }

            if (preview) {
                const cty = preview.getContext('2d');
                cty.clearRect(0, 0, preview.width, preview.height);
            }
        }

        // Reset overlay dan timer
        const timerOverlay = document.getElementById('timerOverlay');
        const countDisplay = document.getElementById('countDisplay');

        if (timerOverlay) timerOverlay.classList.add('hidden');
        if (countDisplay) countDisplay.classList.add('hidden');

        // Opsional: reinisialisasi kamera jika diperlukan
        // initCamera();

        console.log('Photos reset successfully');
    }

</script>
@endpush
