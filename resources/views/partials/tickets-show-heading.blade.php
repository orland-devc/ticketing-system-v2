<div class="relative md:mb-4 w-full">
    <div class="flex items-center justify-between">
        <div class="hidden md:block mb-3">
            <p class="font-medium text-2xl">
                {{ $ticket->subject }}
            </p>
            <p class="text-md text-zinc-500 dark:text-zinc-400 mt-1">
                {{ $ticket->user->full_name }} • 
                <span class="text-sm">
                    @if ($ticket->created_at->isToday())
                        {{ $ticket->created_at->format('g:i A') }}
                    @elseif ($ticket->created_at->isCurrentYear())
                        {{ $ticket->created_at->format('M j') }}
                    @else
                        {{ $ticket->created_at->format('M j, Y') }}
                    @endif
                </span>
            </p>
        </div>
    </div>
    <flux:separator variant="subtle" class="hidden md:block" />
</div>
