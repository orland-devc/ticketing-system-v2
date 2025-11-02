<?php

use App\Models\UserRequest;
use Livewire\Volt\Component;

new class extends Component {
    public $allRequests;

    public function mount(): void
    {
        $this->loadRequests();
    }

    public function refreshThis(): void
    {
        $this->loadRequests();
    }

    private function loadRequests(): void
    {
        $this->allRequests = UserRequest::where('approved', false)
            ->where('rejected', false)
            ->get();
    }
};
?>

<div wire:poll.3s="refreshThis" class="me-10 w-full pb-2 md:w-[220px]">
    <flux:navlist class="hidden md:block mb-6">
        <flux:navlist.settings-item icon="circle-user" :href="route('users.all')" :current="request()->routeIs('users.all')" wire:navigate>{{ __('All Users') }}</flux:navlist.settings-item>
        <flux:navlist.settings-item count="{{ $allRequests->count() }}" icon="lock" :href="route('users.request')" :current="request()->routeIs('users.request')" wire:navigate>{{ __('Requests') }}</flux:navlist.settings-item>
    </flux:navlist>

    <div class="flex items-center gap-4 md:hidden -mt-2 mx-2">
        <flux:navlist.settings-item icon="circle-user" :href="route('users.all')" :current="request()->routeIs('users.all')" wire:navigate>{{ __('All Users') }}</flux:navlist.settings-item>
        <flux:navlist.settings-item icon="lock" :href="route('users.request')" :current="request()->routeIs('users.request')" wire:navigate>{{ __('Requests') }}</flux:navlist.settings-item>
    </div>
</div>