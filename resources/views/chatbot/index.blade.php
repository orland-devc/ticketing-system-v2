<x-layouts.app :title="__('Chatbot')" >
    <div class="relative flex flex-col md:gap-3 min-h-full justify-center max-w-screen md:max-w-full">
        <div class="flex justify-center">
            <div class="absolute top-0 bottom-0 flex sm:w-full md:w-3/4 lg:w-200 flex-1 flex-col m-auto md:rounded-lg overflow-x-hidden max-w-screen md:max-w-full">
                <link rel="stylesheet" href="{{ asset('css/bot.css') }}">
                <div class="flex items-center gap-2 md:gap-4 px-3 md:px-6 py-2 md:py-3 bg-gradient-to-br from-[#667eea] to-[#764ba2] dark:from-blue-900/50 dark:to-purple-900/50 text-white">
                    <img src="{{ asset($botSettings->profile_picture) }}" alt="Tony Stark" class="h-10 w-10 md:h-15 md:w-15 rounded-full md:border-3 border-zinc-300/50">
                    <div class="flex flex-col">
                        <h1 class="text-lg font-bold capitalize">{{ $botSettings->name }}</h1>
                        <p class="text-xs hidden md:block">A Smart Campus Assistant for your concerns. For PSUSCC only.</p>
                        <p class="text-xs text-green-500 md:hidden">● Online</p>
                    </div>
                </div>
                <div id="chat-messages" class="max-h-full h-full overflow-y-auto p-4 bg-zinc-100 text-sm"></div>
                <div class="flex p-4 bg-white dark:bg-zinc-800">
                    <textarea id="user-input" rows="1" 
                        class="w-full px-4 py-2 rounded-4xl text-sm min-h-10 max-h-24 bg-white dark:bg-zinc-700 focus:ring-0 outline-none border-2 focus:border-blue-500 transition-all resize-none overflow-hidden" 
                        placeholder="Write a message..." 
                        autofocus
                    ></textarea>
                    <button class="send-button bg-gradient-to-br from-[#667eea] to-[#764ba2] dark:from-blue-900/50 dark:to-purple-900/50 text-white ml-2 cursor-pointer flex items-center justify-center text-xl h-10 w-12 object-cover overflow-hidden hover:scale-105 rounded-full">
                        <i class="fas fa-paper-plane rotate-45 -ml-2"></i>
                    </button>
                </div>
            </div>
        </div>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.botSettings = {
            time: "{{ now()->format('M d, Y H:i:s') }}",
            username: "{{ Auth::user()->first_name }}",
            name: "{{ $botSettings->name }}",
            profile_picture: "{{ asset($botSettings->profile_picture) }}",
            character: "{{ $botSettings->character }}",
            role: "{{ $botSettings->role }}",
            personality: "{{ $botSettings->personality }}",
            behavior: "{{ $botSettings->behavior }}",
            greeting: "{{ $botSettings->greeting_message }}",
            error: "{{ $botSettings->error_message }}"
        };
        window.faqs = @json($faqs);
    </script>
    <script src="{{ asset('js/bot.js') }}"></script>
</x-layouts.app>