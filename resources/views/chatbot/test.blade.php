<x-layouts.app :title="__('Test Chatbot')">
    <div class="relative flex flex-col gap-3">
        <div class="">
            <section class="w-full">
                @include('partials.chatbot-heading')
                <x-chatbot.layout :heading="__('All Users')" :subheading="__('Keep updated on users, staff, and head')">
                    <livewire:chatbot.index />
                </x-chatbot.layout>
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


<link rel="stylesheet" href="{{ asset('css/bot.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    window.botSettings = {
        profile_picture: "{{ asset($botSettings->profile_picture) }}",
        system_prompt: "{{ $botSettings->system_prompt }}",
        greeting: "{{ $botSettings->greeting_message }}",
        error: "{{ $botSettings->error_message }}"
    };
</script>
<script src="{{ asset('js/bot.js') }}"></script>