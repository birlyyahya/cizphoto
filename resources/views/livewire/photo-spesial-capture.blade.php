<div>
    <div x-data="{ card: false, showCard: false}" class="flex flex-col md:flex-row gap-6">
        <!-- Camera Preview Section -->
        <div class="flex-1 justify-center">
            <div class="relative justify-items-center">
                <video id="video" autoplay class="w-[300px] h-[220px] sm:w-[480px] sm:h-[360px] md:w-[640px] md:h-[480px] object-cover bg-gray-100 rounded-lg shadow-inner -scale-x-100"></video>
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
                <flux:button icon="cake" style="display:none;" id="resetButton" onclick="resetPhotos(event)">
                    Happy Birthday!
                </flux:button>
                <div class="flex">
                    <flux:select id="countSelector" placeholder="" class="field-sizing-content">
                        <flux:select.option value="100">100 (khusus buat gek dwi)</flux:select.option>
                        <flux:select.option value="3">3</flux:select.option>
                        <flux:select.option value="5">5</flux:select.option>
                        <flux:select.option value="10">10</flux:select.option>
                    </flux:select>
                </div>
            </div>
        </div>
        <div
        x-show='card' class="fixed inset-0 flex items-center justify-center bg-black/50 z-90">
            <img
            x-transition:enter="transition transform duration-500 ease-out"
            x-transition:enter-start="scale-50 opacity-0"
            x-transition:enter-end="scale-100 opacity-100"
            x-transition:leave="transition transform duration-500 ease-in"
            x-transition:leave-start="scale-100 opacity-100"
            x-transition:leave-end="scale-50 opacity-0"
            x-show='showCard' src="{{ asset('Image/card.png') }}" class="w-1/2" alt="" class="absolute">
               <!-- Tombol Keluar -->
               <button @click="card = false; showCard = false;" class="absolute top-2 right-2 text-white px-3 py-1 rounded-full transition">
                X
            </button>
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
                <!-- HTML with Tailwind classes -->

                <flux:modal.trigger name="next" class="hidden" id="nextStep">
                    <flux:button variant="primary">Next</flux:button>
                </flux:modal.trigger>

                <flux:modal name="next" class="w-3/4 h-4/5 md:w-full max-w-2xl max-h-screen md:h-fit bg-zinc-200 gap-5">
                    <div x-data="{ frameColor: '#ffffff'}" class="grid grid-cols-1 md:grid-cols-2 h-fit gap-5">
                        <div class="frame mb-2 flex flex-col order-last md:order-first gap-5">
                            <label class="color-picker flex items-center border bg-white rounded-lg px-2 py-1 border-slate-300 gap-3">
                                <input type="color" style="border-radius: 100%;" x-model="frameColor" :value="frameColor" class="h-8 w-8 block cursor-pointer disabled:opacity-50 disabled:pointer-events-none" id="colorinput" title="Choose your color">
                                <label for="colorinput" class="">Custom warna sendiri!</label>
                            </label>
                            <div class="template-color space-y-2 gap-2 mt-2">
                                <x-partials.radioColor>
                                </x-partials.radioColor>
                            </div>
                            <div class="flex grow-1 gap-5 mt-5 p-10 md:m-0 md:p-0 md:justify-normal justify-center">
                                <flux:button id="downloadPhoto" @click="downloadImage(event);card = true; setTimeout(() => showCard = true, 500); $flux.modals().close()" variant="primary" class="self-end">Download
                                    <flux:badge variant="pill" color="warning">1</flux:badge>
                                </flux:button>
                                <flux:button class="self-end">Send Email</flux:button>
                            </div>
                        </div>
                        <div id="framePhotobooth" class="space-y-2 flex flex-col aspect-[9/16] w-64 md:w-80 h-fit  p-5 mx-auto justify-self-center justify-center md:justify-normal  items-center" :class="`bg-${frameColor}-500`" :style="{ backgroundColor: frameColor }">
                            {{-- @foreach ($this->photo as $key => $value ) --}}
                            <div class="relative flex justify-center">
                                <canvas id="previewDownload1" class="w-5/6 aspect-[4/3] object-cover bg-gray-100 shadow-inner"></canvas>
                                <div class="absolute inset-0 flex">
                                </div>
                            </div>
                            <div class="relative flex justify-center">
                                <canvas id="previewDownload2" class="w-5/6 aspect-[4/3] object-cover bg-gray-100  shadow-inner"></canvas>
                                <div class="absolute inset-0 flex">
                                </div>
                            </div>
                            <div class="relative flex justify-center">
                                <canvas id="previewDownload3" class="w-5/6 aspect-[4/3] object-cover bg-gray-100  shadow-inner"></canvas>
                                <div class="absolute inset-0 flex">
                                </div>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="absolute md:bottom-7 bottom-10" viewBox="0 0 600 300">
                                <defs>
                                    <!-- Filter for creating a background that follows text contours -->
                                    <filter id="textBg" x="-10%" y="-10%" width="120%" height="140%">
                                        <!-- Create thickened text shape -->
                                        <feMorphology in="SourceAlpha" operator="dilate" radius="8" result="thickText" />
                                        <!-- Create the background color -->
                                        <feFlood :flood-color="frameColor" result="bgColor" />
                                        <!-- Apply the background color to the thickened text -->
                                        <feComposite in="bgColor" in2="thickText" operator="in" result="textBg" />
                                        <!-- Place original text on top -->
                                        <feMerge>
                                            <feMergeNode in="textBg" />
                                            <feMergeNode in="SourceGraphic" />
                                        </feMerge>
                                    </filter>
                                </defs>

                                <!-- "Happy" text on top -->
                                <text x="50%" y="40%" text-anchor="middle" class="text-5xl md:text-5xl" dominant-baseline="middle" font-family="sans-serif" font-size="50" font-weight="bold" :fill="frameColor === '#ffffff' ? 'black' : 'white'" filter="url(#textBg)">
                                    Happy
                                </text>

                                <!-- "Birthday" text with adjusted position -->
                                <text x="50%" y="60%" text-anchor="middle" class="text-5xl md:text-5xl" dominant-baseline="middle" font-family="sans-serif" font-size="50" font-weight="bold" :fill="frameColor === '#ffffff' ? 'black' : 'white'" filter="url(#textBg)">
                                    Birthday
                                </text>
                            </svg>
                            <h1 class="text-center text-xs py-5 mt-5" :class="frameColor === '#ffffff' ? 'text-black' : 'text-white'" :style="{ backgroundColor: frameColor }">
                                JAGOAN 🥷
                            </h1>
                        </div>
                    </div>
                </flux:modal>
            </div>
        </div>
    </div>
    <img src="{{ asset('Image/animasi-trompet.gif') }}" id="gif-animasi" alt="" class="fixed hidden bottom-5 left-0  -rotate-20">
    <img src="{{ asset('Image/animasi-trompet.gif') }}" id="gif-animasi" alt="" class="fixed hidden bottom-5 right-0 scale-x-[-1] rotate-20">
    <img src="{{ asset('Image/splash.gif') }}" alt="" id="gif-animasi" class="fixed hidden top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-1/2 h-1/2">

</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/html2canvas-pro@1.5.8/dist/html2canvas-pro.min.js"></script>
<script>
    let imageCapture = null;
    let mediaStream = null;
    let currentPhotoIndex = 1;
    let countDown = 3;

    // Hilang setelah 3 detik

    document.getElementById('countSelector').addEventListener('change', function(event) {
        countDown = parseInt(event.target.value); // Ubah nilai count
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize camera
        initCamera();

        // Additional initialization for iPhone
        if (/iPhone/.test(navigator.userAgent) && !window.MSStream) {
            console.log("iPhone detected, applying special handling");

            // Force showing the video element
            const videoElement = document.getElementById('video');
            videoElement.style.display = 'block';
            videoElement.style.width = '100%';
            videoElement.style.height = 'auto';

            // Ensure the video element has correct attributes
            videoElement.setAttribute('playsinline', '');
            videoElement.setAttribute('autoplay', '');
            videoElement.setAttribute('muted', '');
        }
    });

    function initCamera() {
        // Check if it's specifically an iPhone
        const isIPhone = /iPhone/.test(navigator.userAgent) && !window.MSStream;

        // Set constraints specifically for iPhone
        const constraints = {
            video: {
                facingMode: "user"
                , width: isIPhone ? {
                    ideal: 1280
                    , min: 640
                } : {
                    ideal: 1280
                }
                , height: isIPhone ? {
                    ideal: 720
                    , min: 480
                } : {
                    ideal: 720
                }
            }
        };

        // Clear any existing stream
        if (mediaStream) {
            mediaStream.getTracks().forEach(track => track.stop());
        }

        navigator.mediaDevices.getUserMedia(constraints)
            .then(stream => {
                mediaStream = stream;
                const videoElement = document.getElementById('video');

                // Essential for iPhone
                videoElement.setAttribute('playsinline', '');
                videoElement.setAttribute('autoplay', '');
                videoElement.setAttribute('muted', '');

                // Set the stream as source
                videoElement.srcObject = stream;

                // Make sure video is playing
                videoElement.play().catch(e => console.error("Error playing video:", e));

                const track = stream.getVideoTracks()[0];

                // For iPhone, make sure we're getting the correct resolution
                if (isIPhone) {
                    console.log("iPhone detected, applying special camera handling");

                    // Force a refresh of the video element after a short delay
                    setTimeout(() => {
                        videoElement.style.display = 'none';
                        setTimeout(() => {
                            videoElement.style.display = 'block';
                        }, 50);
                    }, 500);
                }

                // Check if ImageCapture is supported
                if (typeof ImageCapture !== 'undefined') {
                    imageCapture = new ImageCapture(track);
                    console.log("ImageCapture supported");
                } else {
                    console.log("ImageCapture not supported, using fallback");
                }
            })
            .catch(error => {
                console.error("Error accessing camera:", error);
                alert("Could not access camera. Please ensure you've granted camera permissions.");
            });
    }

    function takePhotoWithCapture(e) {
        if (e) e.preventDefault();

        const videoElement = document.getElementById('video');
        const canvas = document.getElementById('takePhotoCanvas' + currentPhotoIndex);
        const preview = document.getElementById('previewDownload' + currentPhotoIndex);

        console.log("Taking photo for index:", currentPhotoIndex);

        // Check if video is ready
        if (!videoElement.videoWidth || !videoElement.videoHeight) {
            console.error("Video dimensions not available yet");
            // Try again after a short delay
            setTimeout(() => takePhotoWithCapture(e), 300);
            return;
        }

        // For iPhone, always use the canvas method
        const isIPhone = /iPhone/.test(navigator.userAgent) && !window.MSStream;

        if (isIPhone || !imageCapture) {
            console.log("Using direct canvas capture method");
            captureFromVideo(videoElement, canvas, preview);
        } else {
            // For other devices, try ImageCapture first
            imageCapture.grabFrame()
                .then(imageBitmap => {
                    console.log("ImageCapture successful");
                    drawMirroredCanvas(canvas, imageBitmap, preview);
                })
                .catch(error => {
                    console.error("Error with ImageCapture:", error);
                    captureFromVideo(videoElement, canvas, preview);
                });
        }

        // Hide countdown overlay
        const countDisplay = document.getElementById('countDisplay');
        const timerOverlay = document.getElementById('timerOverlay');
        if (countDisplay) countDisplay.classList.add('hidden');
        if (timerOverlay) timerOverlay.classList.add('hidden');

        // Log success
        console.log("Photo taken for index:", currentPhotoIndex);

        // Increment photo index
        currentPhotoIndex++;
    }

    function captureFromVideo(videoElement, canvas, preview) {
        if (!videoElement || !canvas) {
            console.error("Video or canvas element not found");
            return;
        }

        const ctx = canvas.getContext('2d');

        // Set canvas dimensions to match video
        canvas.width = videoElement.videoWidth;
        canvas.height = videoElement.videoHeight;

        // Check if it's an iPhone
        const isIPhone = /iPhone/.test(navigator.userAgent) && !window.MSStream;

        if (isIPhone) {
            // For iPhone: We need to mirror the image because the default stream is NOT mirrored
            // (contrary to what happens in other browsers)
            ctx.save();
            ctx.translate(canvas.width, 0);
            ctx.scale(-1, 1);
            ctx.drawImage(videoElement, 0, 0, canvas.width, canvas.height);
            ctx.restore();
        } else {
            // For non-iPhone browsers: Apply the mirroring you already had
            ctx.save();
            ctx.translate(canvas.width, 0);
            ctx.scale(-1, 1);
            ctx.drawImage(videoElement, 0, 0, canvas.width, canvas.height);
            ctx.restore();
        }

        // Same handling for preview canvas
        if (preview) {
            const cty = preview.getContext('2d');
            preview.width = videoElement.videoWidth;
            preview.height = videoElement.videoHeight;

            if (isIPhone) {
                // Mirror for iPhone too
                cty.save();
                cty.translate(preview.width, 0);
                cty.scale(-1, 1);
                cty.drawImage(videoElement, 0, 0, preview.width, preview.height);
                cty.restore();
            } else {
                // Mirror for other browsers as before
                cty.save();
                cty.translate(preview.width, 0);
                cty.scale(-1, 1);
                cty.drawImage(videoElement, 0, 0, preview.width, preview.height);
                cty.restore();
            }
        }
    }

    function runSquencePhoto(e) {
        if (e) e.preventDefault();
        const takePhotoButton = document.getElementById('takePhotoButton');
        document.getElementById('countSelector').style.display = 'none';
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
                        takePhotoButton.textContent = 'Happy Birthday!';
                        document.querySelectorAll("#gif-animasi").forEach(el => {
                                el.classList.remove('hidden');
                            });
                        setTimeout(() => {
                            document.querySelectorAll("#gif-animasi").forEach(el => {
                                el.style.display = "none";
                            });
                        }, 3000);
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
            downloadLink.download = 'Birthdayy-photo.png';

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
