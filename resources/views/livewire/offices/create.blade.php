<?php

use App\Models\User;
use App\Models\Office;
use Livewire\Volt\Component;

new class extends Component {
    public $officeUsers;
    public $name;
    public $head;
    public $offices;

    public $role = '';
    public $office_id = '';
    public $first_name = '';
    public $middle_name = '';
    public $last_name = '';
    public $name_suffix = '';
    public $email = '';
    public $password = 'DefaultPassword123';

    public function mount(): void
    {
        $this->officeUsers = User::whereIn('role', ['head', 'staff'])
            ->orderBy('first_name')
            ->get();

        $this->offices = Office::orderBy('name')->get();
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

    public function createUser(): void
    {
        $rules = [
            'role' => 'required|string|in:head,staff',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ];

        if (in_array($this->role, ['head', 'staff'])) {
            $rules['office_id'] = 'required|exists:offices,id';
        }

        $this->validate($rules);

        $data = [
            'role' => $this->role,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name ?: null,
            'name_suffix' => $this->name_suffix ?: null,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
        ];

        if (in_array($this->role, ['head', 'staff'])) {
            $data['office_id'] = $this->office_id;
        }

        $user = User::create($data);

        if ($this->role == 'head') {
            Office::find($this->office_id)->update([
                'head' => $user->id,
            ]);
        }

        $this->reset([
            'role',
            'office_id',
            'first_name',
            'middle_name',
            'last_name',
            'name_suffix',
            'email',
            'password',
        ]);

        $this->dispatch('user-created');

        $this->dispatch('toast', 
            message: 'User created successfully!',
            type: 'success',
            duration: 5000
        );
    }
};
?>


<div class=" flex items-center" x-data="{ createModal: false, createStaffModal: false }">
    <div class="hidden md:block">
        @if (request()->routeIs('offices.index'))
            <flux:button variant="primary" @click="createModal = true" >
                <i class="fas fa-plus ml-1"></i>
                <span class="mr-2">New Office</span>
            </flux:button>
        @elseif (request()->routeIs('offices.staffs'))
            <flux:button variant="primary" @click="createStaffModal = true" >
                <i class="fas fa-plus ml-1"></i>
                <span class="mr-2">New Staff</span>
            </flux:button>
        @endif
    </div>

    @if (request()->routeIs('offices.index'))
        <button @click="createModal = true" class="md:hidden fixed bottom-5 right-5 flex items-center justify-center h-15 w-15 rounded-full bg-blue-500 z-50 shadow-lg lg:hidden hover:bg-blue-600 active:scale-95 active:bg-blue-600 transition-all">
            <i class="fas fa-plus text-white"></i>
        </button>
    @elseif (request()->routeIs('offices.staffs'))
        <button @click="createStaffModal = true" class="fixed bottom-5 right-5 flex items-center justify-center h-13 w-13 rounded-full bg-blue-500 z-30 shadow-lg lg:hidden hover:bg-blue-600 active:scale-95 active:bg-blue-600 transition-all">
            <i class="fas fa-plus text-white text-xl"></i>
        </button>
    @endif

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

    <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 backdrop-blur-sm"
        x-show="createStaffModal"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-effect="document.body.classList.toggle('overflow-hidden', createStaffModal)"
        x-cloak>
        
        <div @click.away="createStaffModal = false" @keydown.escape.window="createStaffModal = false" class="bg-white dark:bg-zinc-800 rounded-lg shadow-lg w-full md:w-3/4 lg:w-200 md:mx-4"
            x-show="createStaffModal"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95">
            <div class="flex justify-between items-center border-b border-gray-200 dark:border-zinc-700 px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Create New User</h2>
                <button @click="createStaffModal = false" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none">
                    <i class="fas fa-times-circle text-xl"></i>
                </button>
            </div>
            <div class="flex flex-col p-6 gap-4">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <flux:select
                        wire:model.defer="role"
                        :label="__('Role')"
                    >
                        <option value="">{{ __('Select role') }}</option>
                        <option value="head">{{ __('Office Head') }}</option>
                        <option value="staff">{{ __('Staff') }}</option>
                    </flux:select>

                    <flux:select
                        wire:model.defer="office_id"
                        :label="__('Office')">
                        <option value="">{{ __('Select Office') }}</option>
                        @foreach($offices as $office)
                            <option value="{{ $office->id }}">{{ $office->name }}</option>
                        @endforeach
                    </flux:select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <flux:input
                        wire:model.defer="first_name" 
                        type="text" 
                        :label="__('First Name')" 
                        :placeholder="__('Juan')" 
                        autofocus
                        required
                    />

                    <flux:input
                        wire:model.defer="middle_name" 
                        type="text" 
                        :label="__('Middle Name')" 
                        :placeholder="__('Reyes')" 
                    />

                    <flux:input
                        wire:model.defer="last_name" 
                        type="text" 
                        :label="__('Last Name')" 
                        :placeholder="__('Dela Cruz')" 
                        required
                    />

                    <flux:input
                        wire:model.defer="name_suffix" 
                        type="text" 
                        :label="__('Suffix')" 
                        :placeholder="__('e.g., Jr., Sr., etc.')" 
                    />

                    <flux:input
                        wire:model.defer="email" 
                        type="email" 
                        :label="__('Email Address')" 
                        :placeholder="__('someone@example.com')" 
                        required
                    />
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                    <flux:input
                        wire:model.defer="password" 
                        type="text" 
                        :label="__('Password')" 
                        required
                    />
                </div>

                <div class="flex justify-end mt-6 gap-3">
                    <flux:button variant="filled" @click="createStaffModal = false">{{ __('Cancel') }}</flux:button>
                    <flux:button variant="primary" wire:click="createUser">{{ __('Create User') }}</flux:button>
                </div>
            </div>
        </div>
    </div>
</div>