<?php

use App\Models\TicketCategory;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Hash;

new class extends Component {

    public $categories;

    public function refreshCategories(): void
    {
        $this->loadCategories();
    }

    public function mount(): void
    {
        $this->loadCategories();
    }

    private function loadCategories():void
    {
        $this->categories = TicketCategory::orderByDesc('name')->get();
    }
};
?>

<div wire:poll.3s="refreshCategories" class="flex sm:w-full md:w-full lg:w-full md:max-w-250 flex-1 flex-col m-auto md:rounded-lg overflow-x-hidden">
    <!-- Tab Content -->
    <div class="p-2 md:max-h-[70vh] lg:max-h-[76vh] overflow-y-auto max-w-full">
        <!-- All Tab -->
        <div class="grid auto-rows-min gap-3">
            <div class="px-4 py-2 -mb-3 text-md font-medium lg:hidden">
                All Categories ({{$categories->count()}})
            </div>
            <div class="gap-2">
                @foreach ($categories as $category)
                    <livewire:tickets.subjects.item :category="$category" :wire:key="'categories-'.$category->id"/>
                @endforeach
                @if ($categories->count() == 0)
                    <div class="px-6 py-16 text-center">
                        <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-zinc-800 flex items-center justify-center">
                            <i class="fas fa-user-shield text-3xl text-gray-400 dark:text-gray-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">No users yet</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Users will appear here once added.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>