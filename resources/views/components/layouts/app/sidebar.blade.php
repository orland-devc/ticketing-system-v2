{{-- sidebar.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-950">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-900 select-none">
            {{-- Logo Section --}}
            <div class="flex items-center justify-between">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-1 rtl:space-x-reverse group" wire:navigate>
                    <div class="flex h-10 w-10 items-center justify-center shadow-blue-500/30 transition-transform group-hover:scale-105">
                        <x-app-logo-icon class="h-6 w-6" />
                    </div>
                    <div class="flex flex-col">
                        <span class="text-lg font-bold text-zinc-900 dark:text-white">{{ config('app.name') }}</span>
                        <span class="text-sm font-medium text-zinc-400 dark:text-zinc-500">{{ ucfirst(Auth::user()->role) }}</span>
                    </div>
                </a>
                <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />
            </div>

            {{-- Quick Stats Card --}}
            <div class="rounded-xl bg-gradient-to-br from-blue-50 to-blue-100/50 p-4 dark:from-blue-950/30 dark:to-blue-900/20 border border-blue-100 dark:border-blue-900/30">
                <div class="flex items-center gap-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-500">
                        @if(auth()->user()->profile_photo_path)
                            <img src="{{ asset(auth()->user()->profile_photo_path) }}" 
                                alt="{{ auth()->user()->last_name }}" 
                                class="h-12 w-12 rounded-lg object-cover">
                        @else
                            <span class="text-lg font-bold text-white">
                                {{ strtoupper(substr(auth()->user()->first_name, 0, 1) . substr(auth()->user()->last_name, 0, 1)) }}
                            </span>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-md font-semibold text-zinc-900 dark:text-white truncate">
                            {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                        </p>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 truncate">
                            {{ auth()->user()->email }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Navigation based on role --}}
            @if (Auth::user()->role == 'admin')
                <flux:navlist variant="outline">
                    <flux:navlist.group :heading="__('Overview')" class="grid">
                        <flux:navlist.item 
                            icon="layout-dashboard" 
                            :href="route('dashboard')" 
                            :current="request()->routeIs('dashboard')" 
                            wire:navigate>
                            {{ __('Dashboard') }}
                        </flux:navlist.item>
                        <flux:navlist.item 
                            icon="chart-column-big" 
                            href="#"
                            count="15">
                            {{ __('Analytics') }}
                        </flux:navlist.item>
                    </flux:navlist.group>

                    <flux:navlist.group :heading="__('Management')" class="grid">
                        <flux:navlist.item 
                            icon="users" 
                            :href="route('users.all')" 
                            :current="request()->routeIs('users*')" 
                            count="users"
                            wire:navigate>
                            {{ __('Users') }}
                        </flux:navlist.item>
                        <flux:navlist.item 
                            icon="building-2" 
                            :href="route('offices.index')" 
                            :current="request()->routeIs('offices.index')" 
                            count="offices"
                            wire:navigate>
                            {{ __('Offices') }}
                        </flux:navlist.item>
                        <flux:navlist.item 
                            icon="tickets" 
                            href="#"
                            count="127">
                            {{ __('Tickets') }}
                        </flux:navlist.item>
                        <flux:navlist.item 
                            icon="bot" 
                            :href="route('chatbot.settings')"
                            :current="request()->routeIs('chatbot*')"
                            wire:navigate>
                            {{ __('Chatbot') }}
                        </flux:navlist.item>
                    </flux:navlist.group>

                    <flux:navlist.group :heading="__('System')" class="grid">
                        <flux:navlist.item 
                            icon="bell" 
                            href="#"
                            count="3"
                            badge-color="blue">
                            {{ __('Notifications') }}
                        </flux:navlist.item>
                        <flux:navlist.item 
                            icon="settings" 
                            :href="route('settings.appearance')" 
                            :current="request()->routeIs('settings*')" 
                            wire:navigate>
                            {{ __('Settings') }}
                        </flux:navlist.item>
                    </flux:navlist.group>
                </flux:navlist>

            @elseif (Auth::user()->role == 'head')
                <flux:navlist variant="outline">
                    <flux:navlist.group :heading="__('Dashboard')" class="grid">
                        <flux:navlist.item 
                            icon="layout-dashboard" 
                            href="#"
                            wire:navigate>
                            {{ __('Overview') }}
                        </flux:navlist.item>
                        <flux:navlist.item 
                            icon="users" 
                            href="#"
                            count="24">
                            {{ __('My Team') }}
                        </flux:navlist.item>
                    </flux:navlist.group>

                    <flux:navlist.group :heading="__('Management')" class="grid">
                        <flux:navlist.item 
                            icon="clipboard-list" 
                            href="#"
                            count="12">
                            {{ __('Tasks') }}
                        </flux:navlist.item>
                        <flux:navlist.item 
                            icon="calendar" 
                            href="#">
                            {{ __('Schedule') }}
                        </flux:navlist.item>
                    </flux:navlist.group>
                </flux:navlist>

            @elseif (Auth::user()->role == 'student')
                <flux:navlist variant="outline">
                    <flux:navlist.group :heading="__('My Space')" class="grid">
                        <flux:navlist.item 
                            icon="layout-dashboard" 
                            href="#"
                            wire:navigate>
                            {{ __('Dashboard') }}
                        </flux:navlist.item>
                        <flux:navlist.item 
                            icon="tickets" 
                            href="#"
                            count="127">
                            {{ __('Tickets') }}
                        </flux:navlist.item>
                        <flux:navlist.item 
                            icon="bot-message-square" 
                            :href="route('ai.chat')"
                            :current="request()->routeIs('ai.chat')">
                            {{ __('Chatbot') }}
                        </flux:navlist.item>
                    </flux:navlist.group>

                    <flux:navlist.group :heading="__('Activity')" class="grid">
                        {{-- <flux:navlist.item 
                            icon="clipboard-check" 
                            href="#"
                            count="3">
                            {{ __('Assignments') }}
                        </flux:navlist.item> --}}
                        <flux:navlist.item 
                            icon="message-circle" 
                            href="#"
                            count="8"
                            wire:poll.3s>
                            {{ __('Messages') }}
                        </flux:navlist.item>
                    </flux:navlist.group>
                </flux:navlist>
            @endif

            <flux:spacer />

            {{-- Help Section --}}
            <div class="hidden mb-3 rounded-xl border border-zinc-200 bg-zinc-50 p-3 dark:border-zinc-800 dark:bg-zinc-800/50">
                <div class="mb-2 flex items-center gap-2">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-500">
                        {{-- <flux:icon.help-circle class="h-4 w-4 text-white" /> --}}
                        <i class="fas fa-question text-white"></i>
                    </div>
                    <span class="text-xs font-semibold text-zinc-900 dark:text-white">Need Help?</span>
                </div>
                <p class="mb-3 text-[11px] leading-relaxed text-zinc-600 dark:text-zinc-400">
                    Check our documentation or reach out to support.
                </p>
                <div class="flex gap-2">
                    <a href="https://laravel.com/docs/starter-kits#livewire" 
                       target="_blank"
                       class="flex-1 rounded-lg bg-white px-2 py-1.5 text-center text-[11px] font-medium text-zinc-700 transition-colors hover:bg-zinc-100 dark:bg-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-600">
                        Docs
                    </a>
                    <a href="https://github.com/laravel/livewire-starter-kit" 
                       target="_blank"
                       class="flex-1 rounded-lg bg-white px-2 py-1.5 text-center text-[11px] font-medium text-zinc-700 transition-colors hover:bg-zinc-100 dark:bg-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-600">
                        GitHub
                    </a>
                </div>
            </div>

            {{-- User Menu Button --}}
            <flux:dropdown position="top" align="start" class="w-full">
                <button class="flex w-full items-center gap-3 rounded-xl border border-zinc-200 bg-white p-3 transition-all hover:border-zinc-300 hover:shadow-sm dark:border-zinc-800 dark:bg-zinc-800/50 dark:hover:border-zinc-700">
                    <div class="relative flex-shrink-0">
                        @if(auth()->user()->profile_photo_path)
                            <img src="{{ asset(auth()->user()->profile_photo_path) }}" 
                                alt="{{ auth()->user()->last_name }}" 
                                class="h-10 w-10 rounded-lg object-cover ring-2 ring-zinc-100 dark:ring-zinc-700">
                        @else
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 ring-2 ring-zinc-100 dark:ring-zinc-700">
                                <span class="text-sm font-bold text-white">
                                    {{ strtoupper(substr(auth()->user()->first_name, 0, 1) . substr(auth()->user()->last_name, 0, 1)) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1 text-left">
                        <div class="truncate text-md font-semibold text-zinc-900 dark:text-white">
                            {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                        </div>
                        <div class="truncate text-sm text-zinc-500 dark:text-zinc-400">View Profile</div>
                    </div>
                    <flux:icon.chevrons-up-down class="h-4 w-4 text-zinc-400" />
                </button>

                <flux:menu class="w-64 fast-animation">
                    <div class="px-3 py-2">
                        <div class="flex items-center gap-3">
                            @if(auth()->user()->profile_photo_path)
                                <img src="{{ asset(auth()->user()->profile_photo_path) }}" 
                                    alt="{{ auth()->user()->last_name }}" 
                                    class="h-10 w-10 rounded-lg object-cover">
                            @else
                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-blue-500 to-blue-600">
                                    <span class="text-sm font-bold text-white">
                                        {{ strtoupper(substr(auth()->user()->first_name, 0, 1) . substr(auth()->user()->last_name, 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                            <div class="min-w-0 flex-1">
                                <div class="truncate text-sm font-semibold text-zinc-900 dark:text-white">
                                    {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                                </div>
                                <div class="truncate text-xs text-zinc-500 dark:text-zinc-400">
                                    {{ auth()->user()->email }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <flux:menu.separator />

                    <flux:menu.item :href="route('settings.profile')" icon="user" wire:navigate>
                        {{ __('My Profile') }}
                    </flux:menu.item>
                    <flux:menu.item icon="cog" href="#">
                        {{ __('Settings') }}
                    </flux:menu.item>
                    <flux:menu.item icon="bell" href="#">
                        {{ __('Notifications') }}
                    </flux:menu.item>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full text-red-600 dark:text-red-400">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        {{-- Mobile Header --}}
        <flux:header class="lg:hidden border-b border-zinc-100 bg-white dark:border-zinc-800 dark:bg-zinc-900">
            <div class="flex items-center gap-4">
                <flux:sidebar.toggle icon="bars-2" class="lg:hidden" inset="left" />

                <div class="flex items-center gap-2">
                    <div class="flex h-8 w-8 items-center">
                        <x-app-logo class="h-5 w-5" />
                    </div>
                    <span class="text-sm font-bold text-zinc-900 dark:text-white">{{ config('app.name') }}</span>
                </div>
            </div>

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <button class="flex items-center gap-2 rounded-lg p-2 transition-colors hover:bg-zinc-100 dark:hover:bg-zinc-800">
                    @if(auth()->user()->profile_photo_path)
                        <img src="{{ asset(auth()->user()->profile_photo_path) }}" 
                            alt="{{ auth()->user()->last_name }}" 
                            class="h-8 w-8 rounded-lg object-cover">
                    @else
                        <div class="flex h-8 w-8 items-center">
                            <span class="text-xs font-bold text-white">
                                {{ strtoupper(substr(auth()->user()->first_name, 0, 1) . substr(auth()->user()->last_name, 0, 1)) }}
                            </span>
                        </div>
                    @endif
                </button>

                <flux:menu class="w-64 fast-down">
                    <div class="px-3 py-2">
                        <div class="flex items-center gap-3">
                            @if(auth()->user()->profile_photo_path)
                                <img src="{{ asset(auth()->user()->profile_photo_path) }}" 
                                    alt="{{ auth()->user()->last_name }}" 
                                    class="h-10 w-10 rounded-lg object-cover">
                            @else
                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-blue-500 to-blue-600">
                                    <span class="text-sm font-bold text-white">
                                        {{ strtoupper(substr(auth()->user()->first_name, 0, 1) . substr(auth()->user()->last_name, 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                            <div class="min-w-0 flex-1">
                                <div class="truncate text-sm font-semibold text-zinc-900 dark:text-white">
                                    {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                                </div>
                                <div class="truncate text-xs text-zinc-500 dark:text-zinc-400">
                                    {{ auth()->user()->email }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <flux:menu.separator />

                    <flux:menu.item :href="route('settings.profile')" icon="user" wire:navigate>
                        {{ __('My Profile') }}
                    </flux:menu.item>
                    <flux:menu.item icon="cog" href="#">
                        {{ __('Settings') }}
                    </flux:menu.item>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full text-red-600 dark:text-red-400">
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