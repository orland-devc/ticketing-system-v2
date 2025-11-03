<?php

use App\Models\Office;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Hash;

new class extends Component {

    public $offices;

    public function refreshOffices(): void
    {
        $this->loadOffices();
    }

    public function mount(): void
    {
        $this->loadOffices();
    }

    private function loadOffices():void
    {
        $this->offices = Office::orderBy('name')->get();
    }
};
?>

<div wire:poll.3s="refreshOffices" class="flex sm:w-full md:w-3/4 lg:w-200 flex-1 flex-col m-auto md:rounded-lg overflow-x-hidden" >
    <!-- Tabs Navigation -->
    <div class="sticky top-0 bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800">
        <div class="flex items-center overflow-x-auto scrollbar-hide">
            <div class="px-4 py-2 text-md font-bold">
                All offices ({{$offices->count()}})
            </div>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="pb-8 px-2 md:px-2 md:py-2">
        <div class="gap-2">
            @foreach ($offices as $office)
                <livewire:offices.edit :office="$office" :wire:key="'office-'.$office->id" />
            @endforeach
            @if ($offices->count() == 0)
                <div class="px-6 py-16 text-center">
                    <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-zinc-800 flex items-center justify-center">
                        <i class="fas fa-users text-3xl text-gray-400 dark:text-gray-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">No offices yet</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">All offices will appear here once added.</p>
                </div>
            @endif
        </div>
    </div>
</div>