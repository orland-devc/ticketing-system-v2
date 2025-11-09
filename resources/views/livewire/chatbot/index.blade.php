<?php

use App\Models\BotSetting;
use Livewire\Volt\Component;

new class extends Component {
    public $botSettings;
    
    public function mount(): void
    {
        $this->botSettings = BotSetting::first();
    }
};
?>

<div class="flex sm:w-full md:w-full lg:max-w-200 flex-1 flex-col m-auto md:rounded-lg overflow-hidden h-[85vh] md:h-[75vh] lg:h-[80vh]">
    <!-- Header - Fixed height -->
    <div class="flex items-center gap-4 px-6 py-3 bg-gradient-to-br from-[#667eea] to-[#764ba2] dark:from-blue-900/50 dark:to-purple-900/50 text-white flex-shrink-0">
        <img src="{{ asset($botSettings->profile_picture) }}" alt="Tony Stark" class="h-15 w-15 rounded-full border-3 border-zinc-300/50">
        <div class="flex flex-col">
            <h1 class="text-lg font-bold capitalize">{{ $botSettings->name }}</h1>
            <p class="text-xs">Exclusice in PSU San Carlos City Campus only.</p>
        </div>
    </div>
    
    <!-- Chat messages - Flexible height -->
    <div id="chat-messages" class="flex-1 overflow-y-auto p-4 bg-zinc-100 text-sm h-full"></div>
    
    <!-- Input area - Fixed height -->
    <div class="flex p-4 bg-white dark:bg-zinc-800 flex-shrink-0">
        <input type="text" id="user-input" class="w-full px-4 py-2 rounded-full text-sm bg-white dark:bg-zinc-700 focus:ring-0 outline-none border-2 focus:border-blue-500 transition-all" placeholder="Write a message..." autofocus autocomplete="off">
        <button class="send-button bg-gradient-to-br from-[#667eea] to-[#764ba2] dark:from-blue-900/50 dark:to-purple-900/50 text-white ml-2 cursor-pointer flex items-center justify-center text-2xl h-12 w-12 object-cover overflow-hidden hover:scale-105 rounded-full min-h-max min-w-max">
            <i class="fas fa-paper-plane rotate-45 -ml-2"></i>
        </button>
    </div>
</div>