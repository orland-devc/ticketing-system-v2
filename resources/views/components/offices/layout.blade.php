<div class="flex items-start max-md:flex-col my-4 md:my-0">
    <div class="me-10 w-full pb-2 md:w-[220px]">
        <flux:navlist class="hidden md:block mb-6 ">
            <flux:navlist.settings-item icon="building-2" count="offices" :href="route('offices.index')" :current="request()->routeIs('offices.index')" wire:navigate>{{ __('Offices') }}</flux:navlist.settings-item>
            <flux:navlist.settings-item icon="briefcase-business" count="staff" :href="route('offices.staffs')" :current="request()->routeIs('offices.staffs')" wire:navigate>{{ __('Heads & Staff') }}</flux:navlist.settings-item>
        </flux:navlist>

        <div class="flex items-center gap-4 md:hidden -mt-2 mx-2">
            <flux:navlist.settings-item icon="building-2" count="offices" :href="route('offices.index')" :current="request()->routeIs('offices.index')" wire:navigate>{{ __('Offices') }}</flux:navlist.settings-item>
            <flux:navlist.settings-item icon="briefcase-business" count="staff" :href="route('offices.staffs')" :current="request()->routeIs('offices.staffs')" wire:navigate>{{ __('Heads & Staff') }}</flux:navlist.settings-item>
        </div>
    </div>

    <flux:separator class="md:hidden" />

    <div class="flex-1 self-stretch">
        <div class="px-2 md:px-0 py-2 md:py-0">
            {{-- <flux:heading size="xl" level="1">{{ $heading ?? '' }}</flux:heading>
            <flux:subheading class="hidden md:block">{{ $subheading ?? '' }}</flux:subheading> --}}
        </div>
        <div class="w-full">
            {{ $slot }}
        </div>
    </div>
</div>
