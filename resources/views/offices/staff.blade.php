<x-layouts.app :title="__('Heads & Staff')" :breadcrumbs="['users.index']">
    <div class="relative flex flex-col gap-3">
        <div class="">
            <section class="w-full">
                @include('partials.offices-heading')
                <x-offices.layout :heading="__('Heads & Staff')" :subheading="__('Keep updated office staff, and head')">
                    <livewire:offices.index  />
                </x-offices.layout>
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