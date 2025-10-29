<?php

use App\Models\User;
use App\Models\Office;
use Livewire\Volt\Component;

new class extends Component {
    public $officeUsers;
    public $name;
    public $head;

    public function mount(): void
    {
        $this->officeUsers = User::whereIn('role', ['head', 'staff'])
            ->orderBy('first_name')
            ->get();
    }

    public function createOffice(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'head' => 'nullable|exists:users,id',
        ]);

        $office = Office::create([
            'name' => $this->name,
        ]);

        User::where('office_id', $office->id)->update([
            'role' => 'staff',
        ]);

        $user = User::find($this->head)->update([
            'role' => 'head',
            'office_id' => $office->id,
        ]);

        $this->reset(['name', 'head']);

        $this->dispatch('office-created');

        $this->dispatch('toast', 
            message: 'Office created successfully!',
            type: 'success',
            duration: 5000
        );
    }
};
?>


<div class=" flex items-center" x-data="{ createModal: false }">
    <button @click="createModal = true" class="hidden md:flex font-semibold dark:bg-white text-white dark:text-black dark:hover:bg-zinc-300 bg-zinc-700 hover:bg-zinc-600/75 transition-all px-2 py-3 rounded-lg">
        <div class="items-center gap-2">
            <i class="fas fa-plus ml-1"></i>
            <span class="mr-2">New Office</span>
        </div>
        {{-- <div class="md:hidden flex items-center gap-2">
            <ion-icon name="add" class="text-xl "></ion-icon>
            <p class="mr-2">New</p>
        </div> --}}
    </button>

    <button @click="createModal = true" class="md:hidden fixed bottom-5 right-5 flex items-center justify-center h-15 w-15 rounded-full bg-blue-500 z-50 shadow-lg lg:hidden hover:bg-blue-600 active:scale-95 active:bg-blue-600 transition-all">
        <i class="fas fa-plus text-white"></i>
    </button>

    <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 backdrop-blur-sm"
        x-show="createModal"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-cloak>
        
        <div @click.away="createModal = false" @keydown.escape.window="createModal = false" class="bg-white dark:bg-zinc-800 rounded-lg shadow-lg w-full md:w-3/4 lg:w-200 md:mx-4"
            x-show="createModal"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95">
            <div class="flex justify-between items-center border-b border-gray-200 dark:border-zinc-700 px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Create New Office</h2>
                <button @click="createModal = false" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none">
                    <i class="fas fa-times-circle text-xl"></i>
                </button>
            </div>
            <div class="flex flex-col p-6 gap-4">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <flux:input
                        wire:model.defer="name"
                        label="Name of the Office"
                        placeholder="e.g., Office of Student Affairs"
                        required
                        autofocus
                    />

                    <flux:select
                        wire:model.defer="head"
                        label="Head"
                    >
                        <option value="">No head assigned</option>
                        @foreach ($officeUsers as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </flux:select>
                </div>
                <div class="flex justify-end mt-6 gap-3">
                    <flux:button variant="filled" @click="createModal = false">{{ __('Cancel') }}</flux:button>
                    <flux:button variant="primary" wire:click="createOffice">{{ __('Create') }}</flux:button>
                </div>
            </div>
        </div>
    </div>
</div>