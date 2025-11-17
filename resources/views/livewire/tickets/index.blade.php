<?php

use App\Models\Ticket;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Hash;

new class extends Component {

    public $tickets;
    public $new;
    public $pending;
    public $resolved;
    public $closed;

    public $activeTab = 'all'; 

    public function refreshTickets(): void
    {
        $this->loadTickets();
    }

    public function mount(): void
    {
        $this->loadTickets();
    }

    private function loadTickets():void
    {
        $this->tickets = Ticket::whereNot('status', 'closed')
            ->orderByDesc('created_at')
            ->get();
        $this->new = Ticket::where('status', 'new')
            ->orderByDesc('created_at')
            ->get();
        $this->pending = Ticket::where('status', 'pending')
            ->orderByDesc('created_at')
            ->get();
        $this->resolved = Ticket::where('status', 'resolved')
            ->orderByDesc('created_at')
            ->get();
        $this->closed = Ticket::where('status', 'closed')
            ->orderByDesc('created_at')
            ->get();
    }
};
?>

<div wire:poll.3s="refreshTickets" class="flex sm:w-full md:w-full lg:w-full md:max-w-250 flex-1 flex-col m-auto md:rounded-lg overflow-x-hidden" x-data="{ activeTab: $wire.entangle('activeTab') }">
    <!-- Tabs Navigation -->
    <div class="sticky top-0 bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800">
        <div class="flex items-center">
            <button @click="activeTab = 'all'" 
                class="flex-1 min-w-fit flex items-center justify-center gap-2 py-3 px-4 transition-all"
                :class="activeTab === 'all' ? 'text-blue-700 dark:text-blue-500 border-b-2 border-blue-700 dark:border-blue-500' : 'text-zinc-400 dark:text-zinc-500 hover:text-gray-700 dark:hover:text-gray-300'">
                <x-lucide-tickets class="w-5 h-5" />
                <span class="text-sm font-medium hidden lg:block">All ({{$tickets->count()}})</span>
            </button>

            <button @click="activeTab = 'new'" 
                class="flex-1 min-w-fit flex items-center justify-center gap-2 py-3 px-4 transition-all"
                :class="activeTab === 'new' ? 'text-blue-700 dark:text-blue-500 border-b-2 border-blue-700 dark:border-blue-500' : 'text-zinc-400 dark:text-zinc-500 hover:text-gray-700 dark:hover:text-gray-300'">
                <x-lucide-ticket-plus class="w-5 h-5" />
                <span class="text-sm font-medium hidden lg:block">New ({{$new->count()}})</span>
            </button>
            
            <button @click="activeTab = 'pending'" 
                class="flex-1 min-w-fit flex items-center justify-center gap-2 py-3 px-4 transition-all"
                :class="activeTab === 'pending' ? 'text-blue-700 dark:text-blue-500 border-b-2 border-blue-700 dark:border-blue-500' : 'text-zinc-400 dark:text-zinc-500 hover:text-gray-700 dark:hover:text-gray-300'">
                <x-lucide-ticket-slash class="w-5 h-5" />
                <span class="text-sm font-medium hidden lg:block">Pending ({{$pending->count()}})</span>
            </button>

            <button @click="activeTab = 'resolved'" 
                class="flex-1 min-w-fit flex items-center justify-center gap-2 py-3 px-4 transition-all"
                :class="activeTab === 'resolved' ? 'text-blue-700 dark:text-blue-500 border-b-2 border-blue-700 dark:border-blue-500' : 'text-zinc-400 dark:text-zinc-500 hover:text-gray-700 dark:hover:text-gray-300'">
                <x-lucide-ticket-check class="w-5 h-5" />
                <span class="text-sm font-medium hidden lg:block">Resolved ({{$resolved->count()}})</span>
            </button>

            <button @click="activeTab = 'closed'" 
                class="flex-1 min-w-fit flex items-center justify-center gap-2 py-3 px-4 transition-all"
                :class="activeTab === 'closed' ? 'text-blue-700 dark:text-blue-500 border-b-2 border-blue-700 dark:border-blue-500' : 'text-zinc-400 dark:text-zinc-500 hover:text-gray-700 dark:hover:text-gray-300'">
                <x-lucide-book-check class="w-5 h-5" />
                <span class="text-sm font-medium hidden lg:block">Closed ({{$closed->count()}})</span>
            </button>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="p-2 md:max-h-[70vh] lg:max-h-[76vh] overflow-y-auto max-w-full">
        <!-- All Tab -->
        <div x-show="activeTab === 'all'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="grid auto-rows-min gap-3">
            <div class="px-4 py-2 -mb-3 text-md font-medium lg:hidden">
                All Tickets ({{$tickets->count()}})
            </div>
            <div class="gap-2">
                @foreach ($tickets as $ticket)
                    <livewire:tickets.edit :ticket="$ticket" :wire:key="'all-'.$ticket->id"/>
                @endforeach
                @if ($tickets->count() == 0)
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

        <!-- New Tab -->
        <div x-show="activeTab === 'new'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="grid auto-rows-min gap-3">
            <div class="px-4 py-2 -mb-3 text-md font-medium lg:hidden">
                New Tickets ({{$new->count()}})
            </div>
            <div class="gap-2">
                @foreach ($new as $ticket)
                    <livewire:tickets.edit :ticket="$ticket" :wire:key="'new-'.$ticket->id"/>
                @endforeach
                @if ($new->count() == 0)
                    <div class="px-6 py-16 text-center">
                        <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-zinc-800 flex items-center justify-center">
                            <i class="fas fa-user-shield text-3xl text-gray-400 dark:text-gray-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">No Administrators yet</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Administrators will appear here once added.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Pending Tab -->
        <div x-show="activeTab === 'pending'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="grid auto-rows-min gap-3">
            <div class="px-4 py-2 -mb-3 text-md font-medium lg:hidden">
                Opened Tickets ({{$pending->count()}})
            </div>
            <div class="gap-2">
                @foreach ($pending as $ticket)
                    <livewire:tickets.edit :ticket="$ticket" :wire:key="'pending-'.$ticket->id"/>
                @endforeach
                @if ($pending->count() == 0)
                    <div class="px-6 py-16 text-center">
                        <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-zinc-800 flex items-center justify-center">
                            <i class="fas fa-person-dots-from-line text-3xl text-gray-400 dark:text-gray-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">No Office Heads yet</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Office Heads will appear here once added.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Resolved Tab -->
        <div x-show="activeTab === 'resolved'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="grid auto-rows-min gap-3">
            <div class="px-4 py-2 -mb-3 text-md font-medium lg:hidden">
                Resolved Tickets ({{$resolved->count()}})
            </div>
            <div class="gap-2">
                @foreach ($resolved as $ticket)
                    <livewire:tickets.edit :ticket="$ticket" :wire:key="'resolved-'.$ticket->id"/>
                @endforeach
                @if ($resolved->count() == 0)
                    <div class="px-6 py-16 text-center">
                        <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-zinc-800 flex items-center justify-center">
                            <i class="fas fa-users-line text-3xl text-gray-400 dark:text-gray-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">No staffs yet</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Staffs will appear here once added.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Closed Tab -->
        <div x-show="activeTab === 'closed'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="grid auto-rows-min gap-3">
            <div class="px-4 py-2 -mb-3 text-md font-medium lg:hidden">
                Closed Tickets ({{$closed->count()}})
            </div>
            <div class="gap-2">
                @foreach ($closed as $ticket)
                    <livewire:tickets.edit :ticket="$ticket" :wire:key="'closed-'.$ticket->id"/>
                @endforeach
                @if ($closed->count() == 0)
                    <div class="px-6 py-16 text-center">
                        <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-zinc-800 flex items-center justify-center">
                            <i class="fas fa-users-line text-3xl text-gray-400 dark:text-gray-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">No staffs yet</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Staffs will appear here once added.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>