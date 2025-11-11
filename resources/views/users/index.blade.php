<x-layouts.app :title="__('Manage Users')" :breadcrumbs="['users.index']">
    <div class="relative flex flex-col gap-3">
        <div class="">
            <section class="w-full">
                @include('partials.users-heading')
                <x-users.layout :heading="__('All Users')" :subheading="__('Keep updated on users, staff, and head')">
                    <livewire:users.index />
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