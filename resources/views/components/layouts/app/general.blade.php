<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js" integrity="sha512-dQIiHSl2hr3NWKKLycPndtpbh5iaHLo6MwrXm7F0FM5e+kL2U16oE9uIwPHUl6fQBeCthiEuV/rzP3MiAB8Vfw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body class="min-h-screen bg-white relative">
    {{-- <div class="absolute top-0 left-0 w-full z-[-1]  backdrop-blur-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="blur-lg" viewBox="0 0 1440 320"><path fill="#ffc1cb" fill-opacity="1" d="M0,32L80,32C160,32,320,32,480,26.7C640,21,800,11,960,16C1120,21,1280,43,1360,53.3L1440,64L1440,0L1360,0C1280,0,1120,0,960,0C800,0,640,0,480,0C320,0,160,0,80,0L0,0Z"></path></svg>
    </div> --}}
    {{ $slot }}
    <div class="absolute bottom-0 left-0 w-full z-[-1]  backdrop-blur-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class=" blur-sm" viewBox="0 0 1440 320"><path fill="#ffc1cb" fill-opacity="1" d="M0,224L80,240C160,256,320,288,480,304C640,320,800,320,960,314.7C1120,309,1280,299,1360,293.3L1440,288L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path></svg>
    </div>
</body>

@fluxScripts
@stack('scripts')

</html>
