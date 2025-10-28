<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public string $first_name = '';
    public string $middle_name = '';
    public string $last_name = '';
    public string $name_suffix = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->first_name = Auth::user()->first_name;
        $this->middle_name = Auth::user()->middle_name ?: '';
        $this->last_name = Auth::user()->last_name;
        $this->name_suffix = Auth::user()->name_suffix ?: '';
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['string', 'max:255'],
            'name_suffix' => ['string', 'max:255'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id)
            ],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->first_name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')">
        <div class="space-y-8">
            {{-- Personal Information Card --}}
            <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
                <div class="px-6 py-5 border-b border-zinc-200 dark:border-zinc-800">
                    <h3 class="text-base font-semibold text-zinc-900 dark:text-white">Personal Information</h3>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">Update your personal details and name</p>
                </div>
                
                <form wire:submit="updateProfileInformation" class="p-6">
                    <div class="space-y-6">
                        {{-- Name Fields Grid --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <flux:input 
                                wire:model="first_name" 
                                :label="__('First Name')" 
                                type="text" 
                                required 
                                autofocus 
                            />

                            <flux:input 
                                wire:model="middle_name" 
                                :label="__('Middle Name')" 
                                type="text" 
                            />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <flux:input 
                                wire:model="last_name" 
                                :label="__('Last Name')" 
                                type="text" 
                                required 
                            />

                            <flux:input 
                                wire:model="name_suffix" 
                                :label="__('Suffix')" 
                                placeholder="(e.g., Jr., Sr.)" 
                                type="text" 
                            />
                        </div>

                        {{-- Divider --}}
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                <div class="w-full border-t border-zinc-200 dark:border-zinc-800"></div>
                            </div>
                            <div class="relative flex justify-center">
                                <span class="bg-white dark:bg-zinc-900 px-3 text-xs font-medium text-zinc-500 dark:text-zinc-400">Contact</span>
                            </div>
                        </div>

                        {{-- Email Field --}}
                        <div>
                            <flux:input 
                                wire:model="email" 
                                :label="__('Email')" 
                                type="email" 
                                required 
                                autocomplete="email" 
                            />

                            @if (! auth()->user()->hasVerifiedEmail())
                                <div class="mt-4 p-4 bg-amber-50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-900 rounded-lg">
                                    <div class="flex items-start gap-3">
                                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-amber-900 dark:text-amber-200">
                                                {{ __('Your email address is unverified.') }}
                                            </p>
                                            <flux:link 
                                                class="text-sm font-medium text-amber-700 dark:text-amber-400 hover:text-amber-800 dark:hover:text-amber-300 cursor-pointer inline-flex items-center gap-1 mt-1" 
                                                wire:click.prevent="resendVerificationNotification"
                                            >
                                                {{ __('Click here to re-send the verification email.') }}
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                                </svg>
                                            </flux:link>

                                            @if (session('status') === 'verification-link-sent')
                                                <p class="mt-3 text-sm font-medium text-green-700 dark:text-green-400 flex items-center gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                    {{ __('A new verification link has been sent to your email address.') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Form Actions --}}
                        <div class="flex items-center justify-between pt-4 border-t border-zinc-200 dark:border-zinc-800">
                            <x-action-message on="profile-updated" class="text-sm font-medium text-green-600 dark:text-green-400 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ __('Saved.') }}
                            </x-action-message>

                            <flux:button variant="primary" type="submit" class="min-w-[120px]">
                                {{ __('Save Changes') }}
                            </flux:button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Delete Account Section --}}
            <livewire:settings.delete-user-form />
        </div>
    </x-settings.layout>
</section>