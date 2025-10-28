<?php

use App\Models\User;
use App\Models\Office;
use Livewire\Volt\Component;

new class extends Component {
    public User $user;

    public $role = '';
    public $student_id = '';
    public $office_id = '';
    public $first_name = '';
    public $middle_name = '';
    public $last_name = '';
    public $name_suffix = '';
    public $email = '';
    public $password = 'DefaultPassword123';

    public $offices;

    public function mount(): void
    {
        $this->offices = Office::orderBy('name')->get();
    }

    public function createUser(): void
    {
        $rules = [
            'role' => 'required|string|in:admin,head,staff,student,alumni',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ];

        if (in_array($this->role, ['head', 'staff'])) {
            $rules['office_id'] = 'required|exists:offices,id';
        } elseif (in_array($this->role, ['student', 'alumni'])) {
            $rules['student_id'] = 'required|string|max:255';
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
        } elseif (in_array($this->role, ['student', 'alumni'])) {
            $data['student_id'] = $this->student_id;
        }

        User::create($data);

        $this->reset([
            'role',
            'student_id',
            'office_id',
            'first_name',
            'middle_name',
            'last_name',
            'name_suffix',
            'email',
            'password',
        ]);

        $this->dispatch('user-created');
    }
};
?>

<div class=" flex items-center" x-data="{ createModal: false, role: @entangle('role') }" x-cloak>
    <button @click="createModal = true" class="hidden md:flex font-semibold dark:bg-white text-white dark:text-black dark:hover:bg-zinc-300 bg-zinc-700 hover:bg-zinc-600/75 transition-all px-2 py-3 rounded-lg">
        <div class="items-center gap-2">
            <i class="fas fa-plus ml-1"></i>
            <span class="mr-2">New User</span>
        </div>
        {{-- <div class="md:hidden flex items-center gap-2">
            <ion-icon name="add" class="text-xl "></ion-icon>
            <p class="mr-2">New</p>
        </div> --}}
    </button>

    <button @click="createModal = true" class="md:hidden fixed bottom-5 right-5 flex items-center justify-center h-15 w-15 rounded-full bg-blue-500 z-30 shadow-lg lg:hidden hover:bg-blue-600 active:scale-95 active:bg-blue-600 transition-all">
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
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Create New User</h2>
                <button @click="createModal = false" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none">
                    <i class="fas fa-times-circle text-xl"></i>
                </button>
            </div>
            <div class="flex flex-col p-6 gap-4">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <flux:select
                        wire:model.defer="role"
                        id="role-select"
                        :label="__('Role')"
                    >
                        <option value="" disabled>{{ __('Select role') }}</option>
                        <option value="admin">{{ __('Administrator') }}</option>
                        <option value="head">{{ __('Office Head') }}</option>
                        <option value="staff">{{ __('Staff') }}</option>
                        <option value="student">{{ __('Student') }}</option>
                        <option value="alumni">{{ __('Alumni') }}</option>
                    </flux:select>

                    {{-- when selected role is student or alumni --}}
                    <div x-show="role === 'student' || role === 'alumni'" x-cloak>
                        <flux:input 
                            wire:model.defer="student_id"
                            type="text"
                            :label="__('Student ID')"
                            :placeholder="__('XX-XX-XXXX')"
                        />
                    </div>

                    {{-- when selected role is head or staff --}}
                    <div x-show="role === 'head' || role === 'staff'" x-cloak>
                        <flux:select
                            wire:model.defer="office_id"
                            :label="__('Office')">
                            <option value="" disabled>{{ __('Select Office') }}</option>
                            @foreach($offices as $office)
                                <option value="{{ $office->id }}">{{ $office->name }}</option>
                            @endforeach
                        </flux:select>
                    </div>

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
                    <flux:button variant="filled" @click="createModal = false">{{ __('Cancel') }}</flux:button>
                    <flux:button variant="primary" wire:click="createUser">{{ __('Create User') }}</flux:button>
                </div>
            </div>
        </div>
    </div>
</div>