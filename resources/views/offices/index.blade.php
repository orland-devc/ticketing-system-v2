<x-layouts.app :title="__('Offices')" :breadcrumbs="['offices.index']">
    <div class="relative flex flex-col gap-3">
        <div class="relative mb-6 w-full hidden lg:block">
            <div class="flex justify-between">
                <div class="">
                    <flux:heading size="xl" level="1">{{ __('Manage Users') }}</flux:heading>
                    <flux:subheading size="lg" class="mb-6">{{ __('View and manage users (Administrators, Head and Staffs, and Students).') }}</flux:subheading>
                </div>
                <livewire:users.create />
            </div>

            <flux:separator variant="subtle" />
            
        </div>

        <div class="lg:hidden">
            <livewire:users.create />
        </div>

        <div class="-mx-4 md:mx-0">
            <div class="flex sm:w-full md:w-3/4 lg:w-200 flex-1 flex-col m-auto md:border md:rounded-lg overflow-x-hidden" >
                <!-- Tabs Navigation -->
                <div class="sticky top-0 bg-white dark:bg-zinc-900 z-10 border-b border-zinc-200 dark:border-zinc-800">
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
                            <div class="group relative bg-white dark:bg-zinc-800/50 rounded-l-2xl border-l-8 border-t border-blue-500 hover:bg-indigo-500/10 transition-all duration-200 cursor-pointer shadow-sm mb-2"
                            >
                                <div class="flex items-center gap-4 p-3">
                                    <!-- Avatar -->
                                    <div class="relative flex-shrink-0">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center ring-2 ring-zinc-100 dark:ring-zinc-700">
                                            <span class="text-white font-semibold text-lg">
                                                {{ strtoupper(substr($office->name, 0, 1))}}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- User Info -->
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-gray-900 dark:text-white text-base truncate">
                                            {{ $office->name }}
                                        </h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 truncate flex items-center gap-1.5 mt-0.5">
                                            <i class="fas fa-user text-xs"></i>
                                            {{ $office->head()?->name ?? 'No assigned head' }}
                                        </p>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex items-center gap-2">
                                        <div class="flex items-center gap-2 mt-1.5">
                                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300">
                                                {{ $office->staffs->count() }} 
                                                @if ($office->staffs->count() <= 1) 
                                                    member
                                                @else
                                                    members
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
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