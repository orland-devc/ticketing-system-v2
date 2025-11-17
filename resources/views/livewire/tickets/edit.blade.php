<?php

use App\Models\User;
use App\Models\Office;
use App\Models\Ticket;
use Livewire\Volt\Component;

new class extends Component {
    public User $user;
    public Ticket $ticket;

    public function click(): void
    {
        $this->dispatch('toast', 
            message: 'Ticket Clicked!',
            type: 'success',
            duration: 5000
        );
    }
};
?>

<a href="{{ route('tickets.show', $ticket) }}">
    <div wire:click="click" class="data-item relative bg-white dark:bg-zinc-800/50 rounded-l-2xl border-l-8 border-t 
        @if ($ticket->level == 'normal') border-green-400
        @elseif ($ticket->level == 'important') border-amber-400
        @elseif ($ticket->level == 'critical') border-red-400
        @endif
        hover:bg-indigo-500/10 transition-all duration-200 cursor-pointer shadow-sm mb-2">
        <div class="flex items-center gap-4 p-3">
            <!-- Avatar -->
            <div class="flex-shrink-0">
                @if($ticket->user->profile_photo_path)
                    <img src="{{ asset($ticket->user->profile_photo_path) }}" 
                        class="w-10 h-10 rounded-full object-cover ring-2 ring-zinc-100 dark:ring-zinc-700">
                @else
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center ring-2 ring-zinc-100 dark:ring-zinc-700">
                        <span class="text-white font-semibold text-lg">
                            {{ strtoupper(substr($ticket->user->first_name, 0, 1) . substr($ticket->user->last_name, 0, 1)) }}
                        </span>
                    </div>
                @endif
            </div>

            <!-- User Info -->
            <div class="flex-1 min-w-0">
                <h3 class="font-semibold text-gray-900 dark:text-white text-base truncate">
                    {{ $ticket->user->full_name }}
                </h3>

                <p class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-1.5 mt-0.5
                truncate whitespace-nowrap max-w-[300px] md:max-w-100 lg:max-w-200">
                    {{ $ticket->content }}
                </p>
            </div>


            <!-- Actions -->
            <div class="flex-shrink-0">
                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 whitespace-nowrap">
                    @if ($ticket->created_at->isToday())
                        {{ $ticket->created_at->format('g:i A') }}
                    @elseif ($ticket->created_at->isCurrentYear())
                        {{ $ticket->created_at->format('M j') }}
                    @else
                        {{ $ticket->created_at->format('M j, Y') }}
                    @endif
                </span>
            </div>
        </div>
    </div>
</a>