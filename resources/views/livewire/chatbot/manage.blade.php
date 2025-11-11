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


<div class="flex w-full lg:max-w-200 flex-col m-auto md:rounded-lg overflow-x-hidden">
    <!-- Tab Content -->
    <div class="pb-8 p-2">
        <!-- Settings Tab -->
        <div class="grid auto-rows-min gap-3">
            <div class="px-2 md:px-0 py-2 -mb-3 text-md font-bold lg:hidden">
                Chatbot Settings
            </div>
            
            <livewire:settings.profile-picture/>

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
    </div>
</div>