<x-layouts.app :title="__('Offices')" :breadcrumbs="['offices.index']">
    <div class="relative flex flex-col gap-3">
        <div class="relative md:mb-6 w-full">
            <div class="flex justify-between">
                <div class="">
                    <flux:heading size="xl" level="1">{{ __('Manage Offices') }}</flux:heading>
                    <flux:subheading size="lg" class="mb-6 hidden md:block">{{ __('View and manage offices for heads and staff.') }}</flux:subheading>
                </div>
                <livewire:offices.create :offices="$offices" />
            </div>

            <flux:separator variant="subtle" />
            
        </div>

        <div class="-mx-4 md:mx-0">
            <div class="flex sm:w-full md:w-3/4 lg:w-200 flex-1 flex-col m-auto md:rounded-lg overflow-x-hidden" >
                <!-- Tabs Navigation -->
                <div class="sticky top-0 bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800">
                    <div class="flex items-center overflow-x-auto scrollbar-hide">
                        <div class="px-4 py-2 text-md font-bold">
                            All offices ({{$offices->count()}})
                        </div>
                    </div>
                </div>

                <!-- Tab Content -->
                <div class="pb-8 px-2 md:px-4 md:py-4">
                    <div class="gap-2">
                        @forelse ($offices as $office)
                            <livewire:offices.edit :office="$office" />
                        @empty
                            <div class="px-6 py-16 text-center">
                                <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-zinc-800 flex items-center justify-center">
                                    <i class="fas fa-users text-3xl text-gray-400 dark:text-gray-600"></i>
                                </div>
                                <h3 class="font-semibold text-gray-900 dark:text-white mb-2">No offices yet</h3>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">All offices will appear here once added.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>