<?php

use App\Models\BotSetting;
use Livewire\Volt\Component;
use Livewire\Attributes\Validate;

new class extends Component {
    public $activeTab = 'settings';

    public $botSettings;
    
    #[Validate('required|string|max:255')]
    public $name;
    
    public $profile_picture;
    
    #[Validate('required|string|max:500')]
    public $character;
    
    #[Validate('required|string|max:500')]
    public $role;
    
    #[Validate('required|string|max:500')]
    public $personality;
    
    #[Validate('required|string|max:500')]
    public $behavior;
    
    #[Validate('required|string|max:1000')]
    public $greeting_message;
    
    #[Validate('required|string|max:1000')]
    public $error_message;

    public function mount(): void
    {
        $this->botSettings = BotSetting::first();
        $this->loadSettings();
    }

    public function loadSettings(): void
    {
        $this->name = $this->botSettings->name;
        $this->profile_picture = $this->botSettings->profile_picture;
        $this->character = $this->botSettings->character;
        $this->role = $this->botSettings->role;
        $this->personality = $this->botSettings->personality;
        $this->behavior = $this->botSettings->behavior;
        $this->greeting_message = $this->botSettings->greeting_message;
        $this->error_message = $this->botSettings->error_message;
    }

    public function save(): void
    {
        $this->validate();

        try {
            $this->botSettings->update([
                'name' => $this->name,
                'character' => $this->character,
                'role' => $this->role,
                'personality' => $this->personality,
                'behavior' => $this->behavior,
                'greeting_message' => $this->greeting_message,
                'error_message' => $this->error_message,
            ]);

            $this->dispatch('notify', 
                type: 'success',
                message: 'Bot settings updated successfully!'
            );

            $this->dispatch('toast', 
                message: 'Bot settings updated successfully!',
                type: 'success',
                duration: 5000
            );

        } catch (\Exception $e) {
            $this->dispatch('notify', 
                type: 'error',
                message: 'Failed to update settings. Please try again.'
            );

            $this->dispatch('toast', 
                message: 'Failed to update settings. Please try again.',
                type: 'danger',
                duration: 5000
            );
        }
    }

    public function restoreDefault(): void
    {
        try {
            $defaults = [
                'character' => 'An AI assistant for Pangasinan State University San Carlos City Campus.',
                'role' => 'Helps with academic and campus-related queries only.',
                'personality' => 'Witty, confident, kind, and helpful. Sometimes talks in Filipino.',
                'behavior' => 'Refuse unrelated queries. Keep responses short (2-3 sentences).',
                'greeting_message' => 'PSU SmartBot here. Ready to help, just tell me what do you need.',
                'error_message' => "I'm having technical difficulties. Try again in a sec.",
            ];

            $this->botSettings->update($defaults);
            $this->loadSettings();

            $this->dispatch('notify', 
                type: 'success',
                message: 'Settings restored to defaults!'
            );

            $this->dispatch('toast', 
                message: 'Settings restored to defaults!',
                type: 'success',
                duration: 5000
            );


        } catch (\Exception $e) {
            $this->dispatch('notify', 
                type: 'error',
                message: 'Failed to restore defaults. Please try again.'
            );

            $this->dispatch('toast', 
                message: 'Failed to restore defaults. Please try again.',
                type: 'danger',
                duration: 5000
            );
        }
    }
};
?>


<div class="flex sm:w-full md:w-full lg:w-200 flex-1 flex-col m-auto md:rounded-lg overflow-x-hidden" x-data="{ activeTab: $wire.entangle('activeTab') }">
    <!-- Tabs Navigation -->
    <div class="sticky top-0 bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800 z-10">
        <div class="flex items-center overflow-x-auto scrollbar-hide">
            <button @click="activeTab = 'settings'" 
                class="flex-1 min-w-fit flex items-center justify-center gap-2 py-3 px-4 transition-all"
                :class="activeTab === 'settings' ? 'text-blue-700 dark:text-blue-500 border-b-2 border-blue-700 dark:border-blue-500' : 'text-zinc-400 dark:text-zinc-500 hover:text-gray-700 dark:hover:text-gray-300'">
                {{-- <i class="fa-solid fa-gear text-lg"></i> --}}
                <x-lucide-settings-2 class="w-6 h-6" />
                <span class="text-sm font-medium hidden lg:block">Chatbot Settings</span>
            </button>

            <button @click="activeTab = 'faqs'" 
                class="flex-1 min-w-fit flex items-center justify-center gap-2 py-3 px-4 transition-all"
                :class="activeTab === 'faqs' ? 'text-blue-700 dark:text-blue-500 border-b-2 border-blue-700 dark:border-blue-500' : 'text-zinc-400 dark:text-zinc-500 hover:text-gray-700 dark:hover:text-gray-300'">
                <i class="fa-solid fa-circle-question text-lg"></i>
                <span class="text-sm font-medium hidden lg:block">FAQs</span>
            </button>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="pb-8 p-2">
        <!-- Settings Tab -->
        <div x-show="activeTab === 'settings'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="grid auto-rows-min gap-3">
            <div class="px-2 md:px-0 py-2 -mb-3 text-md font-bold lg:hidden">
                Chatbot Settings
            </div>
            <form wire:submit="save" class="px-2 md:px-0">
                <div class="flex flex-col gap-4">
                    <flux:textarea 
                        wire:model="character"
                        :label="__('Character')"
                        required
                        rows="2"
                        placeholder="What's the bot's character?"
                    />
                    
                    <flux:textarea 
                        wire:model="role"
                        :label="__('Role')"
                        required
                        rows="2"
                        placeholder="What's the bot's role?"
                    />
                    
                    <flux:textarea 
                        wire:model="personality"
                        :label="__('Personality')"
                        required
                        rows="2"
                        placeholder="What's the bot's personality?"
                    />
                    
                    <flux:textarea 
                        wire:model="behavior"
                        :label="__('Behavior')"
                        required
                        rows="2"
                        placeholder="What's the bot's behavior?"
                    />
                    
                    <flux:textarea 
                        wire:model="greeting_message"
                        :label="__('Greeting Message')"
                        required
                        rows="2"
                        placeholder="Greeting message"
                    />
                    
                    <flux:textarea 
                        wire:model="error_message"
                        :label="__('Error Message')"
                        required
                        rows="2"
                        placeholder="Error message"
                    />
                </div>

                <div class="flex items-center justify-end gap-3 mt-6">
                    <flux:button 
                        type="button" 
                        variant="filled"
                        wire:click="restoreDefault"
                        wire:confirm="Are you sure you want to restore default settings? This will overwrite your current configuration."
                    >
                        <i class="fa-solid fa-rotate-left mr-2"></i>
                        {{__('Restore Default')}}
                    </flux:button>

                    <flux:button type="submit" variant="primary">
                        {{__('Save Changes')}}
                    </flux:button>
                </div>
            </form>
        </div>

        <!-- FAQs Tab -->
        <div x-show="activeTab === 'faqs'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="grid auto-rows-min gap-3">
            <div class="px-2 md:px-0 py-2 -mb-3 text-md font-bold lg:hidden">
                FAQs
            </div>
            <div class="gap-2">
                <div class="w-full h-full py-16">
                    <div class="flex flex-col items-center justify-center gap-4">
                        <div class="w-20 h-20 rounded-full bg-gray-100 dark:bg-zinc-800 flex items-center justify-center">
                            <i class="fa-solid fa-circle-question text-3xl text-gray-400 dark:text-gray-600"></i>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                            FAQs Management
                        </h1>
                        <p class="text-gray-500 dark:text-gray-400 text-center max-w-md">
                            FAQ management functionality will be implemented here. You can add, edit, and manage frequently asked questions.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>