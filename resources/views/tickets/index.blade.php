<x-layouts.app :title="__('Manage Users')" :breadcrumbs="['users.index']">
    <div class="relative flex flex-col gap-3">
        <div class="">
            <section class="w-full">
                @include('partials.tickets-heading')
                <x-tickets.layout>
                    <livewire:tickets.index />
                </x-tickets.layout>
            </section>
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