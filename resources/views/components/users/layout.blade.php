<div class="flex items-start max-md:flex-col">
    <div class="me-10 w-full pb-4 md:w-[220px]">
        <flux:navlist class="hidden md:block mb-6">
            <flux:navlist.settings-item icon="circle-user" :href="route('users.index')" :current="request()->routeIs('users.index')" wire:navigate>{{ __('Profile') }}</flux:navlist.settings-item>
            <flux:navlist.settings-item icon="lock" :href="route('settings.password')" :current="request()->routeIs('settings.password')" wire:navigate>{{ __('Password') }}</flux:navlist.settings-item>
        </flux:navlist>

        <div class="flex items-center gap-4 md:hidden -mt-2">
            <flux:navlist.settings-item icon="circle-user" :href="route('settings.profile')" :current="request()->routeIs('settings.profile')" wire:navigate>{{ __('Profile') }}</flux:navlist.settings-item>
            <flux:navlist.settings-item icon="lock" :href="route('settings.password')" :current="request()->routeIs('settings.password')" wire:navigate>{{ __('Password') }}</flux:navlist.settings-item>
        </div>
    </div>

    <flux:separator class="md:hidden" />

    <div class="flex-1 self-stretch max-md:pt-6">
        <flux:heading>{{ $heading ?? '' }}</flux:heading>
        <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>

        <div class="mt-5 w-full max-w-lg">
            {{ $slot }}
        </div>
    </div>
</div>
