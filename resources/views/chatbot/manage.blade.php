<x-layouts.app :title="__('Manage Chatbot')">
    <div class="relative flex flex-col gap-3">
        <div class="">
            <section class="w-full">
                @include('partials.chatbot-heading')
                <x-chatbot.layout>
                    <livewire:chatbot.manage  />
                </x-chatbot.layout>
            </section>
        </div>
    </div>
</x-layouts.app>