<x-layouts.app :title="__('Manage Users')" :breadcrumbs="['users.index']">
    <div class="relative flex flex-col gap-3">
        <div class="relative md:mb-6 w-full">
            <div class="flex justify-between">
                <div class="">
                    <flux:heading size="xl" level="1">{{ __('Manage Users') }}</flux:heading>
                    <flux:subheading size="lg" class="mb-6 hidden md:block">{{ __('View and manage users (Administrators, Head and Staffs, and Students).') }}</flux:subheading>
                </div>
                <div class="flex items-center gap-4">
                    <livewire:users.request :offices="$offices" />
                    <livewire:users.create :offices="$offices" />
                </div>
            </div>

            <flux:separator variant="subtle" />
            
        </div>

        {{-- <div class="lg:hidden">
            <livewire:users.create :offices="$offices" />
        </div> --}}

        <div class="-mx-4 md:mx-0">
            <livewire:users.index  />
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