<?php

use App\Models\Ticket;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Hash;

new class extends Component {

    public $tickets;

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
        $this->tickets = Ticket::orderByDesc('created_at')->get();
    }
};
?>

<div wire:poll.3s="refreshTickets" class="flex w-full md:max-w-full lg:max-w-250 flex-1 flex-col md:rounded-lg" >

    <!-- Tab Content -->
    <div class="pb-8 px-2 md:px-0 md:py-2">
        <div class="gap-2">
            @foreach ($tickets as $ticket)
                <livewire:tickets.edit :ticket="$ticket" :wire:key="'ticket-'.$ticket->id" />
            @endforeach
            @if ($tickets->count() == 0)
                <div class="px-6 py-16 text-center">
                    <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-zinc-800 flex items-center justify-center">
                        <i class="fas fa-users text-3xl text-gray-400 dark:text-gray-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">No tickets today</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">All submitted tickets will appear here..</p>
                </div>
            @endif
        </div>
    </div>
</div>