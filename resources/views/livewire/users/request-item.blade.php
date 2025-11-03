<?php

use App\Models\User;
use App\Models\UserRequest;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Hash;

new class extends Component {
    public UserRequest $userRequest;

    public $reject_reason = '';
    public $other_reason = '';

    public function approve(): void
    {
        $request = $this->userRequest;

        User::create([
            'student_id' => $request->student_id,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name ?: null,
            'last_name' => $request->last_name,
            'name_suffix' => $request->name_suffix ?: null,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->student_id),
        ]);

        $request->approved = true;
        $request->save();

        $this->dispatch('toast', 
            message: 'Request approved. Account created successfully!',
            type: 'success',
            duration: 5000
        );
    }

    public function reject(): void
    {
        $request = $this->userRequest;
        
        $reason = $this->reject_reason === 'other'
            ? $this->other_reason
            : $this->reject_reason;

        $this->validate([
            'reject_reason' => 'required',
            'other_reason' => $this->reject_reason === 'other' ? 'required|min:3' : 'nullable',
        ]);

        $request->rejected = true;
        $request->reason = $reason;
        $request->save();

        $this->dispatch('toast',
            message: 'Request rejected successfully.',
            type: 'success',
            duration: 5000
        );

        $this->reset(['reject_reason', 'other_reason']);
    }
};
?>

<div x-data="{ 
        viewModal: false, 
        bgModal: false, 
        rejectModal: false, 
        rejectBgModal: false, 
    }" 
    x-cloak>
    <div @click="viewModal = true; bgModal = true;" class="group relative bg-white dark:bg-zinc-800/50 rounded-l-2xl border-l-8 border-t 
        @if ($userRequest?->role == 'student') border-green-500
        @elseif ($userRequest?->role == 'alumni') border-purple-500
        @endif
        hover:bg-indigo-500/10 transition-all duration-200 shadow-sm mb-2 cursor-pointer">
        <div class="flex items-center gap-4 p-3">
            <!-- Avatar -->
            <div class="relative flex-shrink-0">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center ring-2 ring-zinc-100 dark:ring-zinc-700">
                    <span class="text-white font-semibold text-lg">
                        {{ strtoupper(substr($userRequest->first_name, 0, 1) . substr($userRequest->last_name, 0, 1)) }}
                    </span>
                </div>
            </div>

            <!-- UserRequest Info -->
            <div class="flex-1 min-w-0 truncate">
                <h3 class="font-semibold text-gray-900 dark:text-white text-base truncate">
                    {{ $userRequest->last_name }}, {{ $userRequest->first_name }} 
                    @if($userRequest->middle_name)
                        {{ substr($userRequest->middle_name, 0, 1) }}.
                    @endif
                    @if($userRequest->name_suffix)
                        {{ $userRequest->name_suffix }}
                    @endif
                </h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-1.5 mt-0.5">
                    <i class="fas fa-envelope text-xs"></i>
                    <span class="truncate">{{ $userRequest->student_id }}</span>
                </p>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-2">
                <div class="flex items-center gap-2 mt-1.5">
                    @if ($userRequest?->role == 'student')
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300">
                            <i class="fas fa-image-portrait text-sm"></i>
                            Student
                        </span>
                    @elseif ($userRequest?->role == 'alumni')
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-xs font-medium bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300">
                            <i class="fas fa-graduation-cap text-sm"></i>
                            Alumni
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 backdrop-blur-sm"
            x-show="bgModal"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            x-cloak>
            
            <div @click.away="viewModal = false; bgModal = false" 
                @keydown.escape.window="viewModal = false; bgModal = false"
                class="bg-white dark:bg-zinc-800 rounded-lg shadow-lg w-full md:w-3/4 lg:w-200 md:mx-4"
                x-show="viewModal"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95">
                <div class="flex justify-between items-center border-b border-gray-200 dark:border-zinc-700 px-6 py-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $userRequest->request_code }}</h2>
                    <button @click="viewModal = false; bgModal = false" @click.stop
                        class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none">
                        <i class="fas fa-times-circle text-xl"></i>
                    </button>
                </div>
                <div class="flex flex-col p-6 gap-4">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <flux:input
                            type="text"
                            :label="__('Student ID')"
                            value="{{ $userRequest->student_id }}"
                            readonly
                        />

                        <flux:input
                            type="text"
                            :label="__('Level')"
                            value="{{ $userRequest->level }}"
                            readonly
                        />

                        <flux:input
                            type="text"
                            :label="__('Name')"
                            value="{{ $userRequest->name }}"
                            readonly
                        />

                        <flux:input
                            type="text"
                            :label="__('Course')"
                            value="{{ $userRequest->course }}"
                            readonly
                        />

                        <flux:input
                            type="text"
                            :label="__('Email')"
                            value="{{ $userRequest->email }}"
                            readonly
                        />

                        <flux:input
                            type="text"
                            :label="__('Proof (Click to view)')"
                            readonly
                        />
                    </div>
                    <div class="flex justify-end mt-4 gap-3">
                        <flux:button variant="subtle" @click="rejectModal = true; bgModal = false; rejectBgModal = true; viewModal = false" @click.stop class="bg-red-600! text-white! hover:bg-red-500! active:bg-red-500! dark:text-white!">{{ __('Reject') }}</flux:button>
                        <flux:button variant="subtle" wire:click="approve" class="bg-green-600! hover:bg-green-500! active:bg-blue-500! text-white! dark:text-white!">{{ __('Approve') }}</flux:button>
                    </div>
                </div>
            </div>
        </div>

        <div @click.stop class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 backdrop-blur-sm"
            x-show="rejectBgModal"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            x-cloak>

            <div
                @click.away="rejectModal = false; bgModal = false" 
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
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $userRequest->request_code }}</h2>
                    <button @click="rejectModal = false; rejectBgModal = false" @click.stop
                        class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none">
                        <i class="fas fa-times-circle text-xl"></i>
                    </button>
                </div>
                <div x-data="{ reject_reason: @entangle('reject_reason') }" x-cloak class="flex flex-col p-6 gap-4">
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
                        <flux:button variant="filled" @click="rejectBgModal = false; rejectModal = false;" >{{ __('Cancel') }}</flux:button>
                        <flux:button variant="subtle" wire:click="reject" class="bg-red-600! text-white! dark:text-white!">{{ __('Confirm Reject') }}</flux:button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>