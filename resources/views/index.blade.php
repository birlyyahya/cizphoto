<x-layouts.guest>
    <div class="flex flex-col items-center justify-center md:m-30 md:p-10 h-fit space-y-4 text-center z-20 absolute md:relative left-1/2 md:left-0 md:top-0 top-1/2 transform -translate-x-1/2 md:-translate-y-0 md:-translate-x-0 -translate-y-1/2">
        <div class="flex justify-center items-center gap-4 md:gap-8">
            <flux:subheading size="xl" class="italic">est</flux:subheading>
            <div class="text-center text-5xl md:text-7xl italic">cizzphoto</div>
            <flux:subheading size="xl" class="italic">2025</flux:subheading>
        </div>
        <p size="sm" class="text-sm mb-10 w-full m-auto text-gray-700">Ini websitenya cizburgerzz selamat fotoooo yangg cantikssssss
        </p>
        {{-- <div class="m-10"> --}}
            {{-- <flux:button variant="primary" href="/photo">Let’s Go!</flux:button> --}}
        {{-- </div> --}}
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
