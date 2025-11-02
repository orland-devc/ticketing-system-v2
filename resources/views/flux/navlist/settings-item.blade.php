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
    $iconClasses = $square ? 'size-5' : 'size-4';

    $classes = collect([
        'h-10 lg:h-8 relative flex items-center gap-3 rounded-lg',
        $square ? 'px-2.5' : '',
        'py-0 text-start w-full px-3 my-px',
        'text-zinc-500 dark:text-white/80',
    ]);

    $variantClasses = match ($variant) {
        'outline' => $accent
            ? [
                'data-current:text-(--color-accent-content) hover:data-current:text-(--color-accent-content)',
                'data-current:bg-white dark:data-current:bg-white/[7%] data-current:border data-current:border-zinc-200 dark:data-current:border-transparent',
                'hover:text-zinc-800 dark:hover:text-white dark:hover:bg-white/[7%] hover:bg-zinc-800/5',
                'border border-transparent',
            ]
            : [
                'data-current:text-zinc-800 dark:data-current:text-zinc-100 data-current:border-zinc-200',
                'data-current:bg-white dark:data-current:bg-white/10 data-current:border data-current:border-zinc-200 dark:data-current:border-white/10 data-current:shadow-xs',
                'hover:text-zinc-800 dark:hover:text-white',
            ],
        default => $accent
            ? [
                'data-current:text-(--color-accent-content) hover:data-current:text-(--color-accent-content)',
                'data-current:bg-zinc-800/[4%] dark:data-current:bg-white/[7%]',
                'hover:text-zinc-800 dark:hover:text-white hover:bg-zinc-800/[4%] dark:hover:bg-white/[7%]',
            ]
            : [
                'data-current:text-zinc-800 dark:data-current:text-zinc-100',
                'data-current:bg-zinc-800/[4%] dark:data-current:bg-white/10',
                'hover:text-zinc-800 dark:hover:text-white hover:bg-zinc-800/[4%] dark:hover:bg-white/10',
            ],
    };

    $classes = $classes->merge($variantClasses)->implode(' ');
@endphp

<flux:button-or-link :attributes="$attributes->class($classes)" data-flux-navlist-item>
    {{-- Leading Icon --}}
    @if ($icon)
        <div class="relative">
            @if (is_string($icon) && $icon !== '')
                {{-- Renders Lucide icon dynamically --}}
                <x-dynamic-component :component="'lucide-' . Str::kebab($icon)" class="{{ $iconClasses }}" />
            @else
                {{ $icon }}
            @endif

            @if ($iconDot)
                <div class="absolute top-[-2px] end-[-2px]">
                    <div class="size-[6px] rounded-full bg-zinc-500 dark:bg-zinc-400"></div>
                </div>
            @endif
        </div>
    @endif

    {{-- Text --}}
    @if ($slot->isNotEmpty())
        <div class="flex-1 text-sm font-medium leading-none whitespace-nowrap [[data-nav-footer]_&]:hidden [[data-nav-sidebar]_[data-nav-footer]_&]:block" data-content>
            {{ $slot }}
        </div>
    @endif

    @if ($count)
        <div class="relative flex-shrink-0">
            <div class="flex h-6 min-w-6 items-center justify-center rounded-lg bg-red-600 px-2 duration-200 group-hover/navitem:scale-105">
                <span class="text-[11px] font-bold text-white tabular-nums">
                    {{ $count > 99 ? '99+' : $count }}
                </span>
            </div>
        </div>
    @endif

    {{-- Trailing Icon --}}
    @if (is_string($iconTrailing) && $iconTrailing !== '')
        <x-dynamic-component :component="'lucide-' . Str::kebab($iconTrailing)" class="size-4" />
    @elseif ($iconTrailing)
        {{ $iconTrailing }}
    @endif

    {{-- Badge --}}
    @if ($badge && !$count)
        <flux:navlist.badge :color="$badgeColor">{{ $badge }}</flux:navlist.badge>
    @endif
</flux:button-or-link>
