<?php

use App\Models\BotSetting;
use Livewire\Volt\Component;

new class extends Component {
    public $activeTab = 'settings';

    public $botSettings;
    
    public function refreshBotSettings(): void
    {
        $this->loadBotSettings();
    }

    public function mount(): void
    {
        $this->loadBotSettings();
    }

    private function loadBotSettings(): void
    {
        $this->botSettings = BotSetting::first();
    }
};
?>


<div wire:poll.3s="refreshBotSettings" class="flex sm:w-full md:w-full lg:w-200 flex-1 flex-col m-auto md:rounded-lg overflow-x-hidden" x-data="{ activeTab: $wire.entangle('activeTab') }">
    <!-- Tabs Navigation -->
    <div class="sticky top-0 bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800">
        <div class="flex items-center overflow-x-auto scrollbar-hide">
            <button @click="activeTab = 'settings'" 
                class="flex-1 min-w-fit flex items-center justify-center gap-2 py-3 px-4 transition-all"
                :class="activeTab === 'settings' ? 'text-blue-700 dark:text-blue-500 border-b-2 border-blue-700 dark:border-blue-500' : 'text-zinc-400 dark:text-zinc-500 hover:text-gray-700 dark:hover:text-gray-300'">
                <i class="fa-solid fa-users text-lg"></i>
                <span class="text-sm font-medium hidden lg:block">Chatbot Settings</span>
            </button>

            <button @click="activeTab = 'faqs'" 
                class="flex-1 min-w-fit flex items-center justify-center gap-2 py-3 px-4 transition-all"
                :class="activeTab === 'faqs' ? 'text-blue-700 dark:text-blue-500 border-b-2 border-blue-700 dark:border-blue-500' : 'text-zinc-400 dark:text-zinc-500 hover:text-gray-700 dark:hover:text-gray-300'">
                <i class="fa-solid fa-user-check text-lg"></i>
                <span class="text-sm font-medium hidden lg:block">FAQs</span>
            </button>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="pb-8 p-2">
        <!-- Requests Tab -->
        <div x-show="activeTab === 'settings'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="grid auto-rows-min gap-3">
            <div class="px-4 py-2 -mb-3 text-md font-bold lg:hidden">
                Chatbot Settings
            </div>
            <div class="gap-2">
                <div class="w-full h-full">
                    <div class="flex items-center justify-center">
                        <h1 class="capitalize text-2xl font-bold">
                            bot settings here
                        </h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Approved Tab -->
        <div x-show="activeTab === 'faqs'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="grid auto-rows-min gap-3">
            <div class="px-4 py-2 -mb-3 text-md font-bold lg:hidden">
                FAQs
            </div>
            <div class="gap-2">
                {{-- @foreach ($approved as $user)
                    <livewire:users.request-item :userRequest="$user" :wire:key="'approved-'.$user->id" />
                @endforeach
                @if ($approved->count() == 0)
                    <div class="px-6 py-16 text-center">
                        <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-zinc-800 flex items-center justify-center">
                            <i class="fas fa-user-check text-3xl text-gray-400 dark:text-gray-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">No approved accounts yet</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Accounts will appear here once added.</p>
                    </div>
                @endif --}}
                <div class="w-full h-full">
                    <div class="flex items-center justify-center">
                        <h1 class="capitalize text-2xl font-bold">
                            FAQs here
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>