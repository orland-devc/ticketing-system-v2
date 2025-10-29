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
                {{ $office->users->count() }} 
                @if ($office->users->count() <= 1) 
                    member
                @else
                    members
                @endif
            </span>
        </div>
    </div>
</div>