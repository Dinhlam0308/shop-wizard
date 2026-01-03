@props([
    'href' => route('dashboard'),
    'label' => 'Dashboard',
    'hotkey' => true,     // set false to disable ⌘/Ctrl+B
    'sticky' => false,    // set true to pin at top
])

@php
$base = 'inline-flex items-center gap-2 rounded-2xl border-2 
         border-gray-300 dark:border-gray-600 px-4 py-2.5 text-sm font-semibold
         text-gray-700 dark:text-gray-100 bg-white/70 dark:bg-gray-800/70
         hover:bg-gray-900 hover:text-white hover:border-gray-900
         dark:hover:bg-gray-700 dark:hover:border-gray-500
         shadow-sm hover:shadow-md backdrop-blur-sm transition-all duration-300';
$stickyCls = $sticky ? ' sticky top-4 z-30 ' : '';
@endphp

<div x-data x-init="
    @if($hotkey)
    window.addEventListener('keydown', (e) => {
        const isCmd = e.metaKey || e.ctrlKey;
        if (isCmd && (e.key === 'b' || e.key === 'B')) { e.preventDefault(); window.location.assign(@js($href)); }
    });
    @endif
" class="{{ $stickyCls }}">
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $base]) }} aria-label="{{ $label }}">
        {{-- Icon: Arrow Left --}}
        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 19l-7-7 7-7"/>
        </svg>

        <span>{{ $label }}</span>

        {{-- Hotkey hint (desktop only) --}}
        @if($hotkey)
        <span class="ml-1 hidden md:inline-flex items-center rounded-lg border border-gray-300/70
                     dark:border-gray-600/70 px-2 py-0.5 text-[11px] font-medium
                     text-gray-500 dark:text-gray-300">
            ⌘ / Ctrl + B
        </span>
        @endif
    </a>
</div>
