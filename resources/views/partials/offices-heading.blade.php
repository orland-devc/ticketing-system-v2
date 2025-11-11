<div class="relative md:mb-6 w-full">
    <div class="flex items-center justify-between">
        <div class="hidden md:block">
            <flux:heading size="xl" level="1">{{ __('Manage Offices & Staff') }}</flux:heading>
            <flux:subheading size="lg" class="mb-6 hidden md:block">{{ __('View and manage offices for heads and staff.') }}</flux:subheading>
        </div>
        <livewire:offices.create/>
    </div>
    <flux:separator variant="subtle" class="hidden md:block" />
</div>
