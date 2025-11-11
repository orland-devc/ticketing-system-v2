<?php

use App\Models\User;
use App\Models\Office;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Hash;

new class extends Component {

    public $allUsers;
    public $admins;
    public $heads;
    public $staffs;
    public $students;
    public $alumni;
    
    public $activeTab = 'all'; // Add this property

    public function refreshUsers(): void
    {
        $this->loadAllUsers();
    }

    public function mount(): void
    {
        $this->loadAllUsers();
    }

    private function loadAllUsers():void
    {
        $this->allUsers = User::whereIn('role', ['head', 'staff'])->orderBy('last_name')->get();
        $this->heads = User::where('role', 'head')
            ->orderBy('last_name')
            ->get();
        $this->staffs = User::where('role', 'staff')
            ->orderBy('last_name')
            ->get();
    }
};
?>

<div wire:poll.3s="refreshUsers" class="flex sm:w-full md:w-full lg:w-full md:max-w-250 flex-1 flex-col m-auto md:rounded-lg overflow-x-hidden" x-data="{ activeTab: $wire.entangle('activeTab') }">
    <!-- Tabs Navigation -->
    <div class="sticky top-0 bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800">
        <div class="flex items-center">
            <button @click="activeTab = 'all'" 
                class="flex-1 min-w-fit flex items-center justify-center gap-2 py-3 px-4 transition-all"
                :class="activeTab === 'all' ? 'text-blue-700 dark:text-blue-500 border-b-2 border-blue-700 dark:border-blue-500' : 'text-zinc-400 dark:text-zinc-500 hover:text-gray-700 dark:hover:text-gray-300'">
                <i class="fa-solid fa-users text-lg"></i>
                <span class="text-sm font-medium hidden lg:block">All ({{$allUsers->count()}})</span>
            </button>
            
            <button @click="activeTab = 'heads'" 
                class="flex-1 min-w-fit flex items-center justify-center gap-2 py-3 px-4 transition-all"
                :class="activeTab === 'heads' ? 'text-blue-700 dark:text-blue-500 border-b-2 border-blue-700 dark:border-blue-500' : 'text-zinc-400 dark:text-zinc-500 hover:text-gray-700 dark:hover:text-gray-300'">
                <i class="fa-solid fa-person-dots-from-line text-lg"></i>
                <span class="text-sm font-medium hidden lg:block">Heads ({{$heads->count()}})</span>
            </button>

            <button @click="activeTab = 'staff'" 
                class="flex-1 min-w-fit flex items-center justify-center gap-2 py-3 px-4 transition-all"
                :class="activeTab === 'staff' ? 'text-blue-700 dark:text-blue-500 border-b-2 border-blue-700 dark:border-blue-500' : 'text-zinc-400 dark:text-zinc-500 hover:text-gray-700 dark:hover:text-gray-300'">
                <i class="fa-solid fa-users-line text-lg"></i>
                <span class="text-sm font-medium hidden lg:block">Staff ({{$staffs->count()}})</span>
            </button>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="p-2 md:max-h-[70vh] lg:max-h-[76vh] overflow-auto">
        <!-- All Tab -->
        <div x-show="activeTab === 'all'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="grid auto-rows-min gap-3">
            <div class="px-4 py-2 -mb-3 text-md font-bold lg:hidden">
                All users ({{$allUsers->count()}})
            </div>
            <div class="gap-2">
                @foreach ($allUsers as $user)
                    <livewire:users.item :user="$user" :wire:key="'all-'.$user->id"/>
                @endforeach
                @if ($allUsers->count() == 0)
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

        <!-- Heads Tab -->
        <div x-show="activeTab === 'heads'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="grid auto-rows-min gap-3">
            <div class="px-4 py-2 -mb-3 text-md font-bold lg:hidden">
                Office Heads ({{$heads->count()}})
            </div>
            <div class="gap-2">
                @foreach ($heads as $user)
                    <livewire:users.item :user="$user" :wire:key="'heads-'.$user->id"/>
                @endforeach
                @if ($heads->count() == 0)
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

        <!-- Staff Tab -->
        <div x-show="activeTab === 'staff'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="grid auto-rows-min gap-3">
            <div class="px-4 py-2 -mb-3 text-md font-bold lg:hidden">
                Staffs ({{$staffs->count()}})
            </div>
            <div class="gap-2">
                @foreach ($staffs as $user)
                    <livewire:users.item :user="$user" :wire:key="'staff-'.$user->id"/>
                @endforeach
                @if ($staffs->count() == 0)
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