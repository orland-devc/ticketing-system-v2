<?php

use App\Models\Faq;
use Livewire\Volt\Component;
use Livewire\Attributes\Validate;

new class extends Component {
    public $faqs;
    
    public function mount(): void
    {
        $this->loadFaqs();
    }

    public function refreshFaqs(): void
    {
        $this->loadFaqs();
    }

    private function loadFaqs(): void
    {
        $this->faqs = Faq::all();
    }
};
?>


<div wire:poll.3s="refreshFaqs" class="flex max-w-full md:max-w-180 lg:max-w-200 flex-col m-auto md:rounded-lg overflow-x-hidden" >

    <!-- Tab Content -->
    <div class="pb-8 px-2 md:px-0 md:py-2">
        <div class="gap-2">
            @foreach ($faqs as $faq)
                <livewire:chatbot.faqs-edit :faq="$faq" :wire:key="'faq-'.$faq->id" />
            @endforeach
            @if ($faqs->count() == 0)
                <div class="px-6 py-16 text-center">
                    <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-zinc-800 flex items-center justify-center">
                        <i class="fas fa-users text-3xl text-gray-400 dark:text-gray-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">No FAQs saved yet</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">All FAQs will appear here once added.</p>
                </div>
            @endif
        </div>
    </div>
</div>