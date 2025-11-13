<?php

use App\Models\User;
use App\Models\Office;
use App\Models\Ticket;
use Livewire\Volt\Component;

new class extends Component {
    public User $user;
    public Office $office;
    public Ticket $ticket;
    public $officeUsers;
    public $name = '';
    public $head = '';

    // public function mount(): void
    // {
    //     $this->officeUsers = User::whereIn('role', ['head', 'staff'])
    //         ->orderBy('first_name')
    //         ->get();

    //     $this->name = $this->office->name;
    //     $this->head = $this->office->head()?->id;
    // }

    // public function editOffice(): void
    // {
    //     $this->validate([
    //         'name' => 'required|string|max:255',
    //         'head' => 'nullable|exists:users,id',
    //     ]);

    //     $this->office->update([
    //         'name' => $this->name,
    //     ]);

    //     User::where('office_id', $this->office->id)->update([
    //         'role' => 'staff',
    //     ]);

    //     $user = User::find($this->head)->update([
    //         'role' => 'head',
    //         'office_id' => $this->office->id,
    //     ]);

    //     $this->dispatch('toast', 
    //         message: 'Office updated successfully!',
    //         type: 'success',
    //         duration: 5000
    //     );
    // }

    // public function deleteOffice(): void
    // {
    //     User::where('office_id', $this->office->id)->update([
    //         'role' => 'staff',
    //         'office_id' => null,
    //     ]);

    //     $this->office->delete();

    //     $this->dispatch('toast', 
    //         message: 'Deleted successfully!',
    //         type: 'success',
    //         duration: 5000
    //     );
    // }
};
?>


<div class="" >
    <div class="data-item relative bg-white dark:bg-zinc-800/50 rounded-l-2xl border-l-8 border-t 
        @if ($ticket->level == 'Normal') border-green-400
        @elseif ($ticket->level == 'Important') border-amber-400
        @elseif ($ticket->level == 'Critical') border-red-400
        @endif
        hover:bg-indigo-500/10 transition-all duration-200 cursor-pointer shadow-sm mb-2 max-w-screen">
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
                <div class="hidden lg:flex items-center  text-sm text-gray-600 dark:text-gray-400 truncate gap-1.5 mt-0.5">
                    <i class="fas fa-qrcode text-xs"></i>
                    {{ $ticket->ticket_code }}
                </div>
                <div class="flex lg:hidden items-center text-sm text-gray-600 dark:text-gray-400 truncate md:max-w-110 lg:max-w-full gap-1.5 mt-0.5">
                    {{ $ticket->content }}
                </div>
            </div>

            <!-- Ticket Info -->
            <div class="hidden lg:block flex-[2.5] min-w-0">
                <h3 class="font-semibold text-gray-900 dark:text-white text-base truncate">
                    {{ $ticket->category }}
                </h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 truncate flex items-center gap-1.5 mt-0.5">
                    {{ $ticket->content }}
                </p>                
            </div>

            <!-- Actions -->
            <div class="flex-shrink-0 items-center justify-end gap-2">
                <div class="flex items-center gap-2 mt-1.5">
                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300">
                        @if ($ticket->created_at->isToday())
                            {{ $ticket->created_at->format('g:i A') }}  <!-- 4:45 PM -->
                        @elseif ($ticket->created_at->isCurrentYear())
                            {{ $ticket->created_at->format('M j') }}    <!-- Nov 13 -->
                        @else
                            {{ $ticket->created_at->format('M j, Y') }} <!-- Nov 13, 2024 -->
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>