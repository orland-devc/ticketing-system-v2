<?php

use App\Models\UserRequest;
use Livewire\Volt\Component;

new class extends Component {
    public $allRequests;
    public $userRequests;
    public $approved;
    public $rejected;
    
    public $activeTab = 'requests'; // Add this property

    public function refreshRequests(): void
    {
        $this->loadAllRequests();
    }

    public function mount(): void
    {
        $this->loadAllRequests();
    }

    private function loadAllRequests(): void
    {
        $this->allRequests = UserRequest::orderByDesc('created_at')->get();
        $this->userRequests = UserRequest::where('approved', false)->where('rejected', false)->orderByDesc('created_at')->get();
        $this->approved = UserRequest::where('approved', true)->where('rejected', false)->orderByDesc('created_at')->get();
        $this->rejected = UserRequest::where('approved', false)->where('rejected', true)->orderByDesc('created_at')->get();
    }
};
?>


<div wire:poll.3s="refreshRequests" class="flex sm:w-full md:w-full lg:w-200 flex-1 flex-col m-auto md:rounded-lg overflow-x-hidden" x-data="{ activeTab: $wire.entangle('activeTab') }">
    <!-- Tabs Navigation -->
    <div class="sticky top-0 bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800">
        <div class="flex items-center overflow-x-auto scrollbar-hide">
            <button @click="activeTab = 'requests'" 
                class="flex-1 min-w-fit flex items-center justify-center gap-2 py-3 px-4 transition-all"
                :class="activeTab === 'requests' ? 'text-blue-700 dark:text-blue-500 border-b-2 border-blue-700 dark:border-blue-500' : 'text-zinc-400 dark:text-zinc-500 hover:text-gray-700 dark:hover:text-gray-300'">
                <i class="fa-solid fa-users text-lg"></i>
                <span class="text-sm font-medium hidden lg:block">Requests ({{$userRequests->count()}})</span>
            </button>

            <button @click="activeTab = 'approved'" 
                class="flex-1 min-w-fit flex items-center justify-center gap-2 py-3 px-4 transition-all"
                :class="activeTab === 'approved' ? 'text-blue-700 dark:text-blue-500 border-b-2 border-blue-700 dark:border-blue-500' : 'text-zinc-400 dark:text-zinc-500 hover:text-gray-700 dark:hover:text-gray-300'">
                <i class="fa-solid fa-user-check text-lg"></i>
                <span class="text-sm font-medium hidden lg:block">Approved ({{$approved->count()}})</span>
            </button>
            
            <button @click="activeTab = 'rejected'" 
                class="flex-1 min-w-fit flex items-center justify-center gap-2 py-3 px-4 transition-all"
                :class="activeTab === 'rejected' ? 'text-blue-700 dark:text-blue-500 border-b-2 border-blue-700 dark:border-blue-500' : 'text-zinc-400 dark:text-zinc-500 hover:text-gray-700 dark:hover:text-gray-300'">
                <i class="fa-solid fa-user-xmark text-lg"></i>
                <span class="text-sm font-medium hidden lg:block">Rejected ({{$rejected->count()}})</span>
            </button>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="pb-8 p-2">
        <!-- Requests Tab -->
        <div x-show="activeTab === 'requests'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="grid auto-rows-min gap-3">
            <div class="px-4 py-2 -mb-3 text-md font-bold lg:hidden">
                Requests ({{$userRequests->count()}})
            </div>
            <div class="gap-2">
                @foreach ($userRequests as $user)
                    <livewire:users.request-item :userRequest="$user" :wire:key="'requests-'.$user->id" />
                @endforeach
                @if ($userRequests->count() == 0)
                    <div class="px-6 py-16 text-center">
                        <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-zinc-800 flex items-center justify-center">
                            <i class="fas fa-users text-3xl text-gray-400 dark:text-gray-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">No users yet</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">All users will appear here once added.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Approved Tab -->
        <div x-show="activeTab === 'approved'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="grid auto-rows-min gap-3">
            <div class="px-4 py-2 -mb-3 text-md font-bold lg:hidden">
                Approved ({{$approved->count()}})
            </div>
            <div class="gap-2">
                @foreach ($approved as $user)
                    <livewire:users.request-item :userRequest="$user" :wire:key="'approved-'.$user->id" />
                @endforeach
                @if ($approved->count() == 0)
                    <div class="px-6 py-16 text-center">
                        <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-zinc-800 flex items-center justify-center">
                            <i class="fas fa-user-check text-3xl text-gray-400 dark:text-gray-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">No approved accounts yet</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Accounts will appear here once added.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Rejected Tab -->
        <div x-show="activeTab === 'rejected'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="grid auto-rows-min gap-3">
            <div class="px-4 py-2 -mb-3 text-md font-bold lg:hidden">
                Rejected ({{$rejected->count()}})
            </div>
            <div class="gap-2">
                @foreach ($rejected as $user)
                    <livewire:users.request-item :userRequest="$user" :wire:key="'rejected-'.$user->id" />
                @endforeach
                @if ($rejected->count() == 0)
                    <div class="px-6 py-16 text-center">
                        <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-zinc-800 flex items-center justify-center">
                            <i class="fas fa-user-xmark text-3xl text-gray-400 dark:text-gray-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">No rejected accounts yet</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Accounts will appear here once added.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>