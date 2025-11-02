<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>

    @include('components.layouts.toast')

    <style>
        .overflow-auto {
            scrollbar-width: thin;
        }
    </style>
</x-layouts.app.sidebar>
