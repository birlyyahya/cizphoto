<x-layouts.guest>
    <div class="m-30 p-10 space-y-4 text-center z-20 relative">
        <div class="grid grid-cols-3 gap-4 relative">
            <div class="absolute w-full">
                <h1 class="text-8xl text-left uppercase font-black w-3/5">She really love to take a photo<h1>
            </div>
            <div class="flex flex-col justify-end">
                    <div class="flex flex-col">
                        <div class="flex justify-between p-2 items-center">
                            <h1 class="mr-5 flex items-center space-x-2 font-medium text-xl" wire:navigate>
                                Follow Us
                            </h1>
                        </div>
                        <flux:separator />
                        <a href="{{ route('dashboard') }}" class="mr-5 p-2 flex justify-between items-center space-x-2" wire:navigate>
                            Tiktok
                            <span>
                                <flux:icon.arrow-up-right variant="mini"/>
                            </span>
                        </a>
                        <flux:separator />
                        <a href="{{ route('dashboard') }}" class="mr-5 flex p-2 items-center justify-between space-x-2" wire:navigate>
                            Instagram
                            <span>
                                <flux:icon.arrow-up-right variant="mini"/>
                            </span>
                        </a>
                        <flux:separator />
                    </div>
            </div>
            <div class="bg-gray-500 h-screen col-span-2">
                <img src="{{asset('storage/background/about2.png')}}" alt="" class="w-full h-full object-cover">
            </div>
        </div>
    </div>
</x-layouts.guest>
