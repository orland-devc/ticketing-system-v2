<?php

use App\Models\User;
use App\Models\UserRequest;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Hash;

new class extends Component {
    public UserRequest $userRequest;
    public $reject_reason = '';

    public function approve(): void
    {
        $user = User::create([
            'student_id' => $userRequest->student_id,
            'first_name' => $userRequest->first_name,
            'middle_name' => $userRequest->middle_name ?: null,
            'last_name' => $userRequest->last_name,
            'name_suffix' => $userRequest->name_suffix ?: null,
            'email' => $userRequest->email,
            'role' => $userRequest->role,
            'password' => Hash::make($userRequest->student_id),
        ]);

        $userRequest->update(['approved' => true]);

        $this->dispatch('toast', 
            message: 'Request approved. Account created successfully!',
            type: 'success',
            duration: 5000
        );
    }
};
?>

<div x-data="{ rejectModal: false, 
        rejectBgModal: false, 
        reject_reason: @entangle('reject_reason')}">
    <div class="flex justify-end mt-4 gap-3">
        <flux:button variant="subtle" @click="rejectModal = true; rejectBgModal = true;" @click.stop class="bg-red-600! text-white! hover:bg-red-500! active:bg-red-500! dark:text-white!">{{ __('Reject') }}</flux:button>
        <flux:button variant="subtle" wire:click="approve" class="bg-green-600! hover:bg-green-500! active:bg-blue-500! text-white! dark:text-white!">{{ __('Approve') }}</flux:button>
    </div>
    <div @click.stop class="fixed inset-0 bg-black/50 flex items-center justify-center z-55 backdrop-blur-sm"
        x-show="rejectBgModal"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-cloak>

        <div
            @click.away="rejectModal = false; rejectBgModal = false" 
            @keydown.escape.window="rejectModal = false; rejectBgModal = false"
            class="bg-white dark:bg-zinc-800 rounded-lg shadow-lg w-full md:w-3/4 lg:w-200 md:mx-4"
            x-show="rejectModal"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95">
            <div class="flex justify-between items-center border-b border-gray-200 dark:border-zinc-700 px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $userRequest?->request_code }}</h2>
                <button @click="rejectModal = false; rejectBgModal = false" @click.stop
                    class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none">
                    <i class="fas fa-times-circle text-xl"></i>
                </button>
            </div>
            <div class="flex flex-col p-6 gap-4">
                <div class="grid grid-cols-1 gap-4">
                    <flux:select wire:model="reject_reason" label="Reason for Rejection" required>
                        <option value="Incomplete Information Provided">Incomplete Information Provided</option>
                        <option value="Invalid or Incorrect Student ID">Invalid or Incorrect Student ID</option>
                        <option value="Name or Personal Details Do Not Match Records">Name or Personal Details Do Not Match Records</option>
                        <option value="Duplicate Account Already Exists">Duplicate Account Already Exists</option>
                        <option value="Missing Required Documents">Missing Required Documents</option>
                        <option value="Unclear or Unreadable Document Submission">Unclear or Unreadable Document Submission</option>
                        <option value="Student Is Not Currently Enrolled">Student Is Not Currently Enrolled</option>
                        <option value="Student Record Not Found in Our System">Student Record Not Found in Our System</option>
                        <option value="Unauthorized or Fraudulent Request Attempt">Unauthorized or Fraudulent Request Attempt</option>
                        <option value="other">Other (Please Specify)</option>
                    </flux:select>

                    <div x-show="reject_reason === 'other'" x-cloak >
                        <flux:input 
                            wire:model.defer="other_reason"
                            type="text"
                            :label="__('Reason')"
                            :placeholder="__('Specify Reason')"
                        />
                    </div>
                </div>
                <div class="flex justify-end mt-6 gap-3">
                    <flux:button variant="subtle" @click="rejectModal = false" @click.stop class="bg-red-600! text-white! dark:text-white!">{{ __('Reject') }}</flux:button>
                    <flux:button variant="subtle" wire:click="createOffice" class="bg-green-600! text-white! dark:text-white!">{{ __('Approve') }}</flux:button>
                </div>
            </div>
        </div>
    </div>
</div>