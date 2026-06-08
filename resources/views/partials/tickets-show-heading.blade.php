<div class="relative md:mb-4 w-full">
    <div class="flex items-center justify-between">
        <div class="hidden md:block mb-3">
            <p class="font-medium text-2xl">
                {{ $ticket->subject }}
            </p>
            <p class="text-md text-zinc-500 dark:text-zinc-400 mt-1 flex gap-2 items-center">
                {{-- @if($ticket->user->profile_photo_path)
                    <img src="{{ asset($ticket->user->profile_photo_path) }}" 
                        alt="{{ $ticket->user->last_name }}" 
                        class="h-8 w-8 rounded-full object-cover ring-2 ring-zinc-100 dark:ring-zinc-700">
                @else
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-br from-blue-500 to-blue-600 ring-2 ring-zinc-100 dark:ring-zinc-700">
                        <span class="text-sm font-bold text-white">
                            {{ strtoupper(substr($ticket->user->first_name, 0, 1) . substr($ticket->user->last_name, 0, 1)) }}
                        </span>
                    </div>
                @endif --}}
                {{ $ticket->user->full_name }} • 
                <span class="text-sm">
                    @if ($ticket->created_at->isToday())
                        Today at {{ $ticket->created_at->format('g:i A') }}
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
