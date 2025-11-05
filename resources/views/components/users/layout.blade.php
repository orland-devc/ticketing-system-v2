<div class="flex items-start max-md:flex-col my-4 md:my-0">
    <div class="me-10 w-full pb-2 md:w-[220px]">
        <flux:navlist class="hidden md:block mb-6 ">
            <flux:navlist.settings-item icon="circle-user" :href="route('users.all')" :current="request()->routeIs('users.all')" wire:navigate>{{ __('All Users') }}</flux:navlist.settings-item>
            <flux:navlist.settings-item count="requests" icon="lock" :href="route('users.request')" :current="request()->routeIs('users.request')" wire:navigate>{{ __('Requests') }}</flux:navlist.settings-item>
        </flux:navlist>

        <div class="flex items-center gap-4 md:hidden -mt-2 mx-2">
            <flux:navlist.settings-item icon="circle-user" :href="route('users.all')" :current="request()->routeIs('users.all')" wire:navigate>{{ __('All Users') }}</flux:navlist.settings-item>
            <flux:navlist.settings-item count="requests" icon="lock" :href="route('users.request')" :current="request()->routeIs('users.request')" wire:navigate>{{ __('Requests') }}</flux:navlist.settings-item>
        </div>
    </div>

    <flux:separator class="md:hidden" />

    <div class="flex-1 self-stretch">
        <div class="w-full">
            {{ $slot }}
        </div>
    </div>
</div>
