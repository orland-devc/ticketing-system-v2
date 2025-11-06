<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen antialiased">
        <!-- Background image with blue overlay -->
        <div class="fixed inset-0 z-0">
            <img src="{{ asset('images/assets/psu-bg.jpg') }}" alt="" class="h-full w-full object-cover">
            <div class="absolute inset-0 bg-blue-300/70 dark:bg-gray-950/90"></div>
        </div>

        <!-- Content -->
        <div class="relative z-10 flex min-h-svh flex-col items-center justify-center gap-6 md:p-10 backdrop-blur-sm">
            <div class="flex w-full max-w-md flex-col gap-6">
                <a href="{{ route('home') }}" class="flex justify-center items-center gap-2 font-medium" wire:navigate>
                    <span class="flex h-16 w-16 items-center justify-center rounded-md">
                        <x-app-logo-icon class="size-16 fill-current text-white" />
                    </span>

                    <span class="text-2xl font-semibold text-white drop-shadow-lg">{{ config('app.name', 'Laravel') }}</span>
                </a>

                <div class="flex flex-col gap-6">
                    <div class="rounded-3xl border bg-white/95 dark:bg-stone-950/95 dark:border-stone-800 text-stone-800 shadow-xl backdrop-blur-sm">
                        <div class="p-8">{{ $slot }}</div>
                    </div>
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>