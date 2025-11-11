<?php

use App\Models\Faq;
use Livewire\Volt\Component;
use Livewire\Attributes\Validate;

new class extends Component {
    public Faq $faq;

    #[Validate('required|string|min:3')]
    public string $question = '';

    #[Validate('required|string|min:3')]
    public string $answer = '';

    public function mount(): void
    {
        $this->question = $this->faq->question;
        $this->answer = $this->faq->answer;
    }

    public function editFAQ(): void
    {
        $this->validate();

        $this->faq->update([
            'question' => $this->question,
            'answer' => $this->answer,
        ]);

        $this->dispatch('faqUpdated');
        $this->dispatch('notify', message: 'FAQ updated successfully!');
    }

    public function deleteFAQ(): void
    {
        $this->faq->delete();

        $this->dispatch('faqDeleted');
        $this->dispatch('notify', message: 'FAQ deleted successfully!');
    }
};
?>


<div class="" x-data="{ createModal: false }">
    <div @click="createModal = true" class="group relative bg-white dark:bg-zinc-800/50 rounded-l-2xl border-l-8 border-t border-blue-500 hover:bg-indigo-500/10 transition-all duration-200 cursor-pointer shadow-sm mb-2">
        @include('livewire.chatbot.faqs-item')
    </div>

    <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 backdrop-blur-sm"
        x-show="createModal"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-cloak>
        
        <div @click.away="createModal = false" @keydown.escape.window="createModal = false" class="bg-white dark:bg-zinc-800 rounded-lg shadow-lg w-full md:max-w-120 md:mx-4"
            x-show="createModal"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95">
            <div class="flex justify-between items-center border-b border-gray-200 dark:border-zinc-700 px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Office</h2>
                <button @click="createModal = false" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none">
                    <i class="fas fa-times-circle text-xl"></i>
                </button>
            </div>
            <div class="flex flex-col p-6 gap-4">

                <div class="grid grid-cols-1 gap-4">
                    <flux:input
                        wire:model.defer="question"
                        :label="__('Question')"
                        placeholder="What's the query?"
                        required
                        autofocus
                    />

                    <flux:textarea 
                        wire:model="answer"
                        :label="__('Answer')"
                        required
                        rows="4"
                        placeholder="What's the answer to this query?"
                    />
                </div>

                <div class="flex justify-end mt-6 gap-3">
                    <flux:button variant="filled" @click="createModal = false">{{ __('Cancel') }}</flux:button>
                    <flux:button variant="primary" wire:click="editFAQ">{{ __('Save') }}</flux:button>
                    <flux:button variant="danger" wire:click="deleteFAQ">{{ __('Delete') }}</flux:button>
                </div>
            </div>
        </div>
    </div>
</div>