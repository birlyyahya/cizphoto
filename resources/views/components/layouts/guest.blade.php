<x-layouts.app.general>
    <flux:main>
        <img src="{{asset('storage/background/pink.webp')}}" class="blur-xl z-10 absolute w-full md:w-2/5 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 opacity-70 rounded-full bg-contain bg-no-repeat bg-center" alt="background" srcset="">
        <flux:navbar class="justify-center gap-5 z-20">
            <flux:navbar.item href="{{route('home')}}" class="text-slate-800" :current="request()->routeIs('home')">Home</flux:navbar.item>
            <flux:navbar.item href="#">Privacy Policy</flux:navbar.item>
        </flux:navbar>
        {{ $slot }}
        <x-footer></x-footer>
    </flux:main>
</x-layouts.app.general>
