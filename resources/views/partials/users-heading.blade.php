<div class="relative md:mb-6 w-full">
    <div class="flex items-center justify-between">
        <div class="hidden md:block">
            <flux:heading size="xl" level="1">{{ __('Manage Users and Requests') }}</flux:heading>
            <flux:subheading size="lg" class="mb-6">{{ __('View and manage users (Administrators, Head and Staffs, Students, and Alumni).') }}</flux:subheading>
        </div>
        <livewire:users.create />
    </div>
    <flux:separator variant="subtle" class="hidden md:block" />
</div>
