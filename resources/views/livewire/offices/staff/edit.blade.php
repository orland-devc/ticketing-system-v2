<?php

use App\Models\User;
use App\Models\Office;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Hash;

new class extends Component {
    public User $user;

    public $offices;

    // Editable fields
    public $role = '';
    public $student_id = '';
    public $office_id = '';
    public $first_name = '';
    public $middle_name = '';
    public $last_name = '';
    public $name_suffix = '';
    public $email = '';
    public $password = '';

    public function mount(): void
    {
        $this->offices = Office::orderBy('name')->get();

        $this->id = $this->user->id;
        $this->role = $this->user->role;
        $this->student_id = $this->user->student_id;
        $this->office_id = $this->user->office_id;
        $this->first_name = $this->user->first_name;
        $this->middle_name = $this->user->middle_name;
        $this->last_name = $this->user->last_name;
        $this->name_suffix = $this->user->name_suffix;
        $this->email = $this->user->email;
    }

    public function editUser(): void
    {
        $rules = [
            'role' => 'required|string|in:admin,head,staff,student,alumni',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
        ];

        if (in_array($this->role, ['head', 'staff'])) {
            $rules['office_id'] = 'required|exists:offices,id';
        } elseif (in_array($this->role, ['student', 'alumni'])) {
            $rules['student_id'] = 'required|string|max:255';
        }

        $this->validate($rules);

        // Update user data
        $data = [
            'role' => $this->role,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name ?: null,
            'last_name' => $this->last_name,
            'name_suffix' => $this->name_suffix ?: null,
            'email' => $this->email,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if (in_array($this->role, ['head', 'staff'])) {
            $data['office_id'] = $this->office_id;
            $data['student_id'] = null;
        } elseif (in_array($this->role, ['student', 'alumni'])) {
            $data['student_id'] = $this->student_id;
            $data['office_id'] = null;
        } else {
            $data['student_id'] = null;
            $data['office_id'] = null;
        }

        if ($this->role == 'head') {
            Office::find($this->office_id)->update([
                'head' => $this->user->id,
            ]);
        }

        $this->user->update($data);

        $this->dispatch('user-updated', id: $this->user->id);

        session()->flash('success', 'User updated successfully!');

        $this->dispatch('toast', 
            message: 'User updated successfully!',
            type: 'success',
            duration: 5000
        );
    }

    public function deleteUser(): void
    {
        $this->user->delete();
        $this->dispatch('user-deleted', id: $this->user->id);
        session()->flash('success', 'User deleted successfully!');

        $this->dispatch('toast', 
            message: 'Entey deleted successfully!',
            type: 'success',
            duration: 5000
        );
    }
};
?>

<div x-cloak>
    {{-- edit modal --}}
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center px-2 z-50 backdrop-blur-sm"
         x-show="editBgModal"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         x-effect="document.body.classList.toggle('overflow-hidden', editBgModal)"
         x-cloak>
        
        <div @click.away="editModal = false; editBgModal = false" @keydown.escape.window="editModal = false; editBgModal = false"
             class="bg-white dark:bg-zinc-800 rounded-lg shadow-lg w-full md:w-3/4 lg:w-200 md:mx-4"
             x-show="editModal"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95">
             
            <div class="flex justify-between items-center border-b border-gray-200 dark:border-zinc-700 px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Edit User</h2>
                <flux:button variant="danger" icon="trash" @click="deleteBgModal = true; deleteModal = true;">
                    {{__('Delete')}}
                </flux:button>
            </div>

            <div class="flex flex-col p-6 gap-4">
                <div class="grid grid-cols-2 gap-4">
                    {{-- Bind Livewire role and Alpine role together --}}
                    <flux:select
                        wire:model="role"
                        id="role-select"
                        :label="__('Role')"
                    >
                        <option value="" disabled>{{ __('Select role') }}</option>
                        <option value="head">{{ __('Office Head') }}</option>
                        <option value="staff">{{ __('Staff') }}</option>
                    </flux:select>

                    <flux:select
                        wire:model.defer="office_id"
                        :label="__('Office')">
                        <option value="" >{{ __('Select Office') }}</option>
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
                    />
                </div>

                <div class="flex justify-end mt-6 gap-3">
                    <flux:button variant="filled" @click="editModal = false; editBgModal = false" >{{ __('Cancel') }}</flux:button>
                    <flux:button variant="primary" wire:click="editUser">{{ __('Save') }}</flux:button>
                </div>
            </div>
        </div>
    </div>

    <div class="fixed inset-0 bg-black/50 flex items-center justify-center px-4 z-50 backdrop-blur-sm"
        x-show="deleteBgModal"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-cloak>

        {{-- delete modal --}}
        <div @click.away="deleteModal = false; deleteBgModal = false" @keydown.escape.window="deleteModal = false; deleteBgModal = false" class="bg-white dark:bg-zinc-800 rounded-lg shadow-lg w-full md:w-160 md:mx-4"
            x-show="deleteModal"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            x-effect="document.body.classList.toggle('overflow-hidden', deleteModal)">
            <div class="flex justify-between items-center border-b border-gray-200 dark:border-zinc-700 px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Delete User</h2>
                <button @click="deleteModal = false; deleteBgModal = false" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none">
                    <i class="fas fa-times-circle text-xl"></i>
                </button>
            </div>
            <div class="flex flex-col p-6 gap-4">
                <div class="flex items-center gap-4">
                    <h1>
                        Are you sure you want to delete
                        <b>{{ $user->name }}</b>'s
                        account?
                    </h1>
                </div>

                <div class="flex justify-end mt-6 gap-3 w-full">
                    <flux:button variant="filled" @click="deleteModal = false; deleteBgModal = false" >{{ __('Cancel') }}</flux:button>
                    <flux:button variant="danger" wire:click="deleteUser">{{ __('Delete') }}</flux:button>
                </div>
            </div>
        </div>
    </div>
</div>