@props(['type' => 'info', 'message' => null])

@php
    $styles = [
        'success' => 'from-emerald-400/25 via-emerald-500/15 to-emerald-300/10 border-emerald-300/40 text-emerald-50 shadow-[0_0_25px_rgba(16,185,129,0.25)]',
        'error'   => 'from-rose-500/25 via-rose-500/15 to-rose-400/10 border-rose-300/40 text-rose-50 shadow-[0_0_25px_rgba(244,63,94,0.25)]',
        'warning' => 'from-amber-400/25 via-amber-500/15 to-amber-300/10 border-amber-300/40 text-amber-50 shadow-[0_0_25px_rgba(245,158,11,0.25)]',
        'info'    => 'from-sky-400/25 via-sky-500/15 to-sky-300/10 border-sky-300/40 text-sky-50 shadow-[0_0_25px_rgba(56,189,248,0.25)]',
    ];
@endphp

@if ($message)
    <div
        x-data="{ show: true }"
        x-cloak x-show="show"
        x-transition:enter="transition ease-out duration-700"
        x-transition:enter-start="opacity-0 translate-y-3 scale-95 blur-sm"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100 blur-0"
        x-transition:leave="transition ease-in duration-500"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-3 scale-95"
        x-init="setTimeout(() => show = false, 4200)"
        class="fixed top-16 right-6 z-[9999] px-5 py-3.5 rounded-2xl border 
               bg-gradient-to-br {{ $styles[$type] }}
               backdrop-blur-2xl backdrop-saturate-200
               shadow-[0_8px_32px_rgba(0,0,0,0.25)]
               ring-1 ring-white/10 hover:ring-white/20
               hover:shadow-[0_12px_48px_rgba(255,255,255,0.15)]
               hover:scale-[1.02] active:scale-[0.98]
               transition-all duration-500 ease-[cubic-bezier(0.4,0,0.2,1)]
               select-none cursor-default group animate-[toast-pop_0.6s_ease-out]">
        <div class="flex items-center gap-3">
            @switch($type)
                @case('success')
                    <x-lucide-check-circle class="w-5 h-5 text-emerald-300 drop-shadow-[0_0_6px_rgba(16,185,129,0.4)]" />
                    @break
                @case('error')
                    <x-lucide-x-circle class="w-5 h-5 text-rose-300 drop-shadow-[0_0_6px_rgba(244,63,94,0.4)]" />
                    @break
                @case('warning')
                    <x-lucide-alert-triangle class="w-5 h-5 text-amber-300 drop-shadow-[0_0_6px_rgba(245,158,11,0.4)]" />
                    @break
                @default
                    <x-lucide-info class="w-5 h-5 text-sky-300 drop-shadow-[0_0_6px_rgba(56,189,248,0.4)]" />
            @endswitch

            <span class="font-medium tracking-wide text-[15px] leading-tight drop-shadow-[0_0_4px_rgba(255,255,255,0.2)]">
                {{ $message }}
            </span>
        </div>

        {{-- Glow reflection layer --}}
        <div class="absolute inset-0 rounded-2xl bg-gradient-to-t from-white/10 via-transparent to-transparent opacity-50 pointer-events-none"></div>
    </div>

    {{-- ✨ Animation styles --}}
    <style>
        @keyframes toast-pop {
            0% {
                opacity: 0;
                transform: translateY(8px) scale(0.94);
                filter: blur(4px) brightness(0.9);
            }
            60% {
                opacity: 1;
                transform: translateY(-2px) scale(1.03);
                filter: blur(0) brightness(1.1);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0) brightness(1);
            }
        }
    </style>
@endif
