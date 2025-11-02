<x-layouts.app :title="__('Manage Requests')">
    <div class="relative flex flex-col gap-3">
        <div class="-mx-4 md:mx-0">
            <section class="w-full">
                @include('partials.users-heading')
                <x-users.layout>
                    <livewire:users.request  />
                </x-users.layout>
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