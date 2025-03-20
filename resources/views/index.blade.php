<x-layouts.guest>
    <div class="flex flex-col items-center w-full justify-center h-fit space-y-4 text-center z-20 absolute top-3/7 left-1/2 transform -translate-x-1/2 -translate-y-1/2 ">
        <div class="flex justify-center items-center lg:gap-8 gap-3">
            <flux:subheading size="xl" class="italic">est</flux:subheading>
            {{-- <div class="text-center text-5xl md:text-7xl italic">cizzphoto</div> --}}
            <img src="{{ asset('storage/background/logoCizz.png') }}" class="min-w-[250px] w-1/3 md:w-1/3" alt="" srcset="">
            <flux:subheading size="xl" class="italic md:-left-10 -left-5 relative">2025</flux:subheading>
        </div>
        <p size="sm" class="text-xs md:text-sm mb-10 w-2/3 md:w-full m-auto text-gray-700">Ini websitenya cizburgerzz selamat fotoooo yangg cantikssssss
        </p>
        <flux:modal.trigger name="delete-profile">
            <flux:button variant="primary">Let's Go!</flux:button>
        </flux:modal.trigger>

        <flux:modal name="delete-profile" class="min-w-[22rem]">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">👋 Pakai iPad atau Laptop Yuk!</flux:heading>

                    <flux:subheading>
                        <p>Website ini lebih seru kalau dibuka di iPad atau laptop. Tampilan lebih jelas, fitur lebih maksimal, dan pengalaman lebih nyaman!</p>
                    </flux:subheading>
                </div>

                <div class="flex flex-col justify-center items-center gap-2">
                    <flux:spacer />
                    <flux:button variant="primary" href="/photo">🚀 Ayo Mulai!</flux:button>
                </div>
            </div>
        </flux:modal>
    </div>
</x-layouts.guest>
