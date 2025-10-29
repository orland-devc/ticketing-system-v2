<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            @if (Auth::user()->role == 'admin')
                <flux:navlist variant="outline">
                    <flux:navlist.group :heading="__('Platform')" class="grid">
                        <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Admin Dashboard') }}</flux:navlist.item>
                        <flux:navlist.item icon="users" :href="route('users.index')" :current="request()->routeIs('users.index')" wire:navigate>{{ __('User Management') }}</flux:navlist.item>
                        <flux:navlist.item icon="building-2" :href="route('offices.index')" :current="request()->routeIs('offices.index')" wire:navigate>{{ __('Offices') }}</flux:navlist.item>
                    </flux:navlist.group>
                </flux:navlist>

            @elseif (Auth::user()->role == 'head')
                <flux:navlist variant="outline">
                    <flux:navlist.group :heading="__('Platform')" class="grid">
                        <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Office Dashboard') }}</flux:navlist.item>
                    </flux:navlist.group>
                </flux:navlist>

            @elseif (Auth::user()->role == 'student')
                <flux:navlist variant="outline">
                    <flux:navlist.group :heading="__('Platform')" class="grid">
                        <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                        <flux:navlist.item icon="ticket" :href="route('tickets.create')" :current="request()->routeIs('tickets.create')" wire:navigate>{{ __('Create a ticket') }}</flux:navlist.item>
                    </flux:navlist.group>
                </flux:navlist>
            @endif

            <flux:spacer />

            <flux:navlist variant="outline">
                <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                {{ __('Repository') }}
                </flux:navlist.item>

                <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                {{ __('Documentation') }}
                </flux:navlist.item>
            </flux:navlist>

            <!-- Desktop User Menu -->
            <flux:dropdown position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->first_name . ' ' . auth()->user()->last_name"
                    icon-trailing="chevrons-up-down"
                >
                    <x-slot:avatar>
                        <div class="relative flex-shrink-0">
                            @if(auth()->user()->profile_photo_path)
                                <img src="{{ asset(auth()->user()->profile_photo_path) }}" 
                                    alt="{{ auth()->user()->last_name }}" 
                                    class="w-8 h-8 rounded-full object-cover ring-2 ring-zinc-100 dark:ring-zinc-700">
                            @else
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center ring-2 ring-zinc-100 dark:ring-zinc-700">
                                    <span class="text-white font-semibold text-lg">
                                        {{ strtoupper(substr(auth()->user()->first_name, 0, 1) . substr(auth()->user()->last_name, 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </x-slot:avatar>
                </flux:profile>

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <div class="relative flex-shrink-0">
                                    @if(auth()->user()->profile_photo_path)
                                        <img src="{{ asset(auth()->user()->profile_photo_path) }}" 
                                            alt="{{ auth()->user()->last_name }}" 
                                            class="w-8 h-8 rounded-full object-cover ring-2 ring-zinc-100 dark:ring-zinc-700">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center ring-2 ring-zinc-100 dark:ring-zinc-700">
                                            <span class="text-white font-semibold text-lg">
                                                {{ strtoupper(substr(auth()->user()->first_name, 0, 1) . substr(auth()->user()->last_name, 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    icon-trailing="chevrons-up-down"
                >
                    <x-slot:avatar>
                        <div class="relative flex-shrink-0">
                            @if(auth()->user()->profile_photo_path)
                                <img src="{{ asset(auth()->user()->profile_photo_path) }}" 
                                    alt="{{ auth()->user()->last_name }}" 
                                    class="w-8 h-8 rounded-full object-cover ring-2 ring-zinc-100 dark:ring-zinc-700">
                            @else
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center ring-2 ring-zinc-100 dark:ring-zinc-700">
                                    <span class="text-white font-semibold text-lg">
                                        {{ strtoupper(substr(auth()->user()->first_name, 0, 1) . substr(auth()->user()->last_name, 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </x-slot:avatar>
                </flux:profile>

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <div class="relative flex-shrink-0">
                                    @if(auth()->user()->profile_photo_path)
                                        <img src="{{ asset(auth()->user()->profile_photo_path) }}" 
                                            alt="{{ auth()->user()->last_name }}" 
                                            class="w-8 h-8 rounded-full object-cover ring-2 ring-zinc-100 dark:ring-zinc-700">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center ring-2 ring-zinc-100 dark:ring-zinc-700">
                                            <span class="text-white font-semibold text-lg">
                                                {{ strtoupper(substr(auth()->user()->first_name, 0, 1) . substr(auth()->user()->last_name, 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
