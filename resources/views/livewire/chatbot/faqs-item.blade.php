<div class="flex items-center gap-4 p-3">
    <div class="flex-1 min-w-0">
        <h3 class="font-semibold text-gray-900 dark:text-white text-base truncate">
            {{ $faq->question }}
        </h3>
        <p class="text-sm text-gray-600 dark:text-gray-400 truncate flex items-center gap-1.5 mt-0.5">
            {{ $faq->answer}}
        </p>
    </div>

    <!-- Actions -->
    <div class="flex items-center gap-2">
        <div class="flex items-center gap-2 mt-1.5">
            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300">
                @if ($faq->created_at->lt(now()->subWeek()))
                    {{ $faq->created_at->toFormattedDateString() }}
                @else
                    {{ $faq->created_at->diffForHumans() }}
                @endif
            </span>
        </div>
    </div>
</div>
