<x-layouts.app :title="__('Offices')" :breadcrumbs="['offices.index']">
    <div class="relative flex flex-col gap-3">
        <div class="relative md:mb-6 w-full">
            <div class="flex justify-between m-4 md:m-0">
                <div class="">
                    <flux:heading size="xl" level="1">{{ __('Manage Offices & Staff') }}</flux:heading>
                    <flux:subheading size="lg" class="mb-6 hidden md:block">{{ __('View and manage offices for heads and staff.') }}</flux:subheading>
                </div>
                <livewire:offices.create :offices="$offices" />
            </div>

            <flux:separator variant="subtle" />
            
        </div>

        <div class="">
            <livewire:offices.index />
        </div>
    </div>
</x-layouts.app>

<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>