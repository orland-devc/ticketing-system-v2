<?php

use App\Models\TicketCategory;
use Livewire\Volt\Component;

new class extends Component {
    public TicketCategory $category;
    public bool $expanded = false;
};
?>

<div x-data="{ 
    expanded: @entangle('expanded'),
    editModal: false, 
    editBgModal: false,
    addSubjectModal: false,
    addSubjectBgModal: false,
    deleteModal: false,
    deleteBgModal: false 
}" class="max-w-screen mb-3">
    
    <!-- Category Header -->
    <div class="relative bg-white dark:bg-zinc-800/50 rounded-l-2xl border-l-8 border-t border-indigo-500
        hover:bg-indigo-500/10 transition-all duration-200 shadow-sm">
        
        <div class="flex items-center gap-4 p-4">
            <!-- Category Info -->
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2">
                    <h3 class="font-semibold text-gray-900 dark:text-white text-lg truncate">
                        {{ $category->name }}
                    </h3>
                </div>
                
                <div class="hidden md:flex items-center gap-3 mt-2 text-xs text-gray-500 dark:text-gray-400">
                    <span class="flex items-center gap-1">
                        <i class="fas fa-list-check"></i>
                        {{ $category->subjects->count() }} {{ Str::plural('subject', $category->subjects->count()) }}
                    </span>
                    <span class="flex items-center gap-1">
                        <i class="fas fa-user"></i>
                        {{ $category->user?->full_name ?? 'Unknown' }}
                    </span>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-2">
                <!-- Add Subject Button -->
                <flux:button variant="primary"
                    {{-- @click.stop="addSubjectModal = true; addSubjectBgModal = true;" --}}
                >
                    <i class="fas fa-plus"></i>
                    <span>Add Subject</span>
                </flux:button>

                <!-- Expand/Collapse Button -->
                <button 
                    @click.stop="expanded = !expanded"
                    class="p-2.5 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-indigo-500/10 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-200">
                    <i class="fas transition-transform duration-200" 
                       :class="expanded ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                </button>
            </div>
        </div>

        <!-- Subjects List (Collapsible) -->
        <div x-show="expanded" 
             x-collapse
             class="border-t border-gray-200 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-900/30 rounded-b-2xl">
            <div class="p-4 space-y-2">
                @forelse($category->subjects as $subject)
                    <div class="group flex items-center justify-between p-3 bg-white dark:bg-zinc-800/50 rounded-lg border border-gray-200 dark:border-zinc-700 hover:border-indigo-300 dark:hover:border-indigo-600 hover:shadow-sm transition-all duration-200">
                        <div class="flex items-center gap-3 flex-1 min-w-0">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-cyan-600 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-tag text-white text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-medium text-gray-900 dark:text-white text-sm truncate">
                                    {{ $subject->name }}
                                </h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                    Added by {{ $category->user?->full_name ?? 'Unknown' }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                            <button 
                                class="p-2 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-blue-500/10 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-200">
                                <i class="fas fa-pen text-xs"></i>
                            </button>
                            <button 
                                class="p-2 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-red-500/10 hover:text-red-600 dark:hover:text-red-400 transition-all duration-200">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <i class="fas fa-inbox text-4xl text-gray-300 dark:text-gray-600 mb-3"></i>
                        <p class="text-sm text-gray-500 dark:text-gray-400">No subjects yet</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Click "Add Subject" to create one</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Modals would be included here -->
    {{-- <livewire:ticket-categories.edit :category="$category" /> --}}
    {{-- <livewire:ticket-subjects.create :category="$category" /> --}}
</div>