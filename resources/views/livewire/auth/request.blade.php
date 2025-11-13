<?php

use App\Models\UserRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $student_id = '';
    public string $first_name = '';
    public string $middle_name = '';
    public string $last_name = '';
    public string $name_suffix = '';
    public string $course = '';
    public string $level = '';
    public string $email = '';

    /**
     * Handle an incoming registration request.
     */
    public function request(): void
    {
        $validated = $this->validate([
            'student_id' => ['required', 'string', 'max:225', Rule::unique('users', 'student_id')],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'name_suffix' => ['string', 'max:255'],
            'course' => ['string', 'max:255'],
            'level' => ['string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')],
        ]);

        $userRequest = UserRequest::create([
            'student_id' => $this->student_id,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'name_suffix' => $this->name_suffix,
            'course' => $this->course,
            'level' => $this->level,
            'role' => $this->level == 'alumni' ? 'alumni' : 'student',
            'email' => $this->email,
        ]);


        $this->redirectIntended(route('request', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Submit an Account Request')" :description="__('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="request" class="flex flex-col gap-6">
        <flux:input
            wire:model="student_id"
            :label="__('Student ID')"
            type="text"
            required
            autofocus
            autocomplete="student_id"
            :placeholder="__('xx-SC-xxxx')"
        />
        <div class="grid grid-cols-2 gap-4">
            <flux:input
                wire:model="course"
                :label="__('Course')"
                type="text"
                required
                autofocus
                autocomplete="course"
                :placeholder="__('e.g., BSED, BSIT, etc.')"
            />
            <flux:select wire:model="level" :label="__('Year Level')" required>
                <option>Select level</option>
                <option value="1-2">1 - 2</option>
                <option value="3-4">3 - 4</option>
                <option value="above 4">Above 4</option>
                <option value="alumni">Alumni</option>
            </flux:select>
            <flux:input
                wire:model="first_name"
                :label="__('First Name')"
                type="text"
                required
                autofocus
                autocomplete="name"
                :placeholder="__('First name')"
            />
            <flux:input
                wire:model="middle_name"
                :label="__('Middle Name')"
                type="text"
                autocomplete="name"
                :placeholder="__('Middle name')"
            />
            <flux:input
                wire:model="last_name"
                :label="__('Last Name')"
                type="text"
                required
                autocomplete="name"
                :placeholder="__('Last name')"
            />
            <flux:input
                wire:model="name_suffix"
                :label="__('Name Suffix')"
                type="text"
                autocomplete="name"
                :placeholder="__('Suffix (e.g., Jr., Sr.)')"
            />
        </div>

        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email address')"
            type="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
        />

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Submit') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('Already have an account?') }}
        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>
</div>
