{{-- navlist/item.blade.php --}}
@php
    use Illuminate\Support\Str;

    $iconTrailing = $iconTrailing ??= $attributes->pluck('icon:trailing');
    $iconVariant = $iconVariant ??= $attributes->pluck('icon:variant');
@endphp

@aware(['variant'])

@props([
    'iconVariant' => 'outline',
    'iconTrailing' => null,
    'badgeColor' => null,
    'variant' => null,
    'iconDot' => null,
    'accent' => true,
    'badge' => null,
    'icon' => null,
    'count' => null,
])

@php
    // Button should be a square if it has no text contents...
    $square ??= $slot->isEmpty();

    // Size-up icons in square/icon-only buttons...
    $iconClasses = $square ? 'size-5' : 'size-[18px]';

    $classes = collect([
        'group/navitem relative flex items-center gap-2 rounded-xl transition-all duration-200',
        $square ? 'h-9 w-9 justify-center' : 'h-9 pr-3 mb-2',
        'text-zinc-600 dark:text-zinc-400',
    ]);

    $variantClasses = match ($variant) {
        'outline' => $accent
            ? [
                // Current/Active state - Blue accent with subtle background
                'data-current:bg-zinc-100 dark:data-current:bg-zinc-800/50',
                'data-current:text-black dark:data-current:text-white',
                'data-current:shadow-sm dark:data-current:shadow-zinc-900/20',
                // Hover states
                'hover:bg-zinc-50 dark:hover:bg-zinc-800/50',
                'hover:text-zinc-900 dark:hover:text-zinc-200',
                'hover:translate-x-0.5',
                'hover:shadow-sm dark:hover:shadow-zinc-900/20',
                // Active interaction
                'active:scale-[0.98]',
            ]
            : [
                'data-current:bg-zinc-100 dark:data-current:bg-zinc-800',
                'data-current:text-zinc-900 dark:data-current:text-zinc-100',
                'hover:bg-zinc-50 dark:hover:bg-zinc-800/50',
                'hover:text-zinc-900 dark:hover:text-zinc-200',
            ],
        default => $accent
            ? [
                'data-current:bg-blue-50 dark:data-current:bg-blue-950/20',
                'data-current:text-blue-700 dark:data-current:text-blue-400',
                'hover:bg-zinc-50 dark:hover:bg-zinc-800/50',
                'hover:text-zinc-900 dark:hover:text-zinc-200',
            ]
            : [
                'data-current:bg-zinc-100 dark:data-current:bg-zinc-800',
                'data-current:text-zinc-900 dark:data-current:text-zinc-100',
                'hover:bg-zinc-50 dark:hover:bg-zinc-800/50',
                'hover:text-zinc-900 dark:hover:text-zinc-200',
            ],
    };

    $classes = $classes->merge($variantClasses)->implode(' ');
@endphp

<flux:button-or-link :attributes="$attributes->class($classes)" data-flux-navlist-item>
    {{-- Leading Icon with enhanced styling --}}
    @if ($icon)
        <div class="relative flex-shrink-0">
            <div class="relative flex h-9 w-9 items-center justify-center rounded-l-lg bg-zinc-100 transition-all duration-200 group-hover/navitem:bg-zinc-200 group-data-current/navitem:bg-gray-800 dark:bg-zinc-800 dark:group-hover/navitem:bg-zinc-700 dark:group-data-current/navitem:bg-zinc-200">
                @if (is_string($icon) && $icon !== '')
                    <x-dynamic-component 
                        :component="'lucide-' . Str::kebab($icon)" 
                        class="{{ $iconClasses }} text-zinc-600 transition-colors group-hover/navitem:text-zinc-900 group-data-current/navitem:text-white dark:group-data-current/navitem:text-black dark:text-zinc-300 dark:group-hover/navitem:text-zinc-200" 
                    />
                @else
                    {{ $icon }}
                @endif

                {{-- Notification dot --}}
                @if ($iconDot)
                    <div class="absolute -right-0.5 -top-0.5">
                        <div class="relative flex h-2 w-2">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex h-2 w-2 rounded-full bg-red-500"></span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- Text with better typography --}}
    @if ($slot->isNotEmpty())
        <div class="flex-1 text-[13px] font-medium leading-none whitespace-nowrap [[data-nav-footer]_&]:hidden [[data-nav-sidebar]_[data-nav-footer]_&]:block transition-colors" data-content>
            {{ $slot }}
        </div>
    @endif

    {{-- Count Badge with attention-grabbing red design --}}
    @if ($count)
        <div class="relative flex-shrink-0">
            <div class="flex h-6 min-w-6 items-center justify-center rounded-lg bg-gradient-to-br from-red-500 to-red-600 px-2 duration-200 group-hover/navitem:scale-105">
                <span class="text-[11px] font-bold text-white tabular-nums">
                    {{ $count > 99 ? '99+' : $count }}
                </span>
            </div>
            @if ($count > 0)
                <div class="absolute -right-0.5 -top-0.5 hidden">
                    <span class="relative flex h-2 w-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-red-400"></span>
                    </span>
                </div>
            @endif
        </div>
    @endif

    {{-- Trailing Icon --}}
    @if (is_string($iconTrailing) && $iconTrailing !== '')
        <div class="flex-shrink-0">
            <x-dynamic-component 
                :component="'lucide-' . Str::kebab($iconTrailing)" 
                class="size-4 text-zinc-400 transition-colors group-hover/navitem:text-zinc-600 dark:text-zinc-500 dark:group-hover/navitem:text-zinc-400" 
            />
        </div>
    @elseif ($iconTrailing)
        {{ $iconTrailing }}
    @endif

    {{-- Badge (alternative to count) --}}
    @if ($badge && !$count)
        <flux:navlist.badge :color="$badgeColor">{{ $badge }}</flux:navlist.badge>
    @endif

    {{-- Subtle active indicator line (additional to border) --}}
    {{-- <div class="absolute bottom-0 left-3 right-3 h-0.5 scale-x-0 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 transition-transform duration-200 group-data-current/navitem:scale-x-100"></div> --}}
</flux:button-or-link>