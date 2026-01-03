<div wire:poll.30s="refresh" class="group hp-card rounded-2xl p-6 hp-hover overflow-hidden">
    {{-- === Main Hero Image === --}}
    <div class="aspect-[4/3] w-full rounded-2xl overflow-hidden relative">
        @php $main = $special; @endphp

        <x-fallback-image 
            src="{{ $main['image'] ?? '/images/hero-hogwarts.jpg' }}"
            alt="{{ $main['name'] ?? 'Always Café - Không gian phép thuật hiện đại' }}"
            class="h-full w-full object-cover transition-all duration-1000 group-hover:scale-105" />

        {{-- === Overlay layers (cleaner contrast) === --}}
        <div class="absolute inset-0 bg-gradient-to-tr from-black/60 via-black/30 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black/50"></div>

        {{-- === Category badge (refined soft glow) === --}}
        @if ($main)
            <div
                class="absolute top-4 left-4 flex items-center gap-2 px-3 py-1.5 rounded-full 
                    backdrop-blur-xl border border-amber-300/40
                    bg-gradient-to-r from-amber-500/40 via-yellow-400/30 to-orange-400/30
                    text-[13px] text-amber-50 font-semibold 
                    shadow-[0_0_12px_rgba(255,220,160,0.25)]">
                <i data-lucide="sparkles" class="w-4 h-4 text-amber-200"></i>
                <span>{{ $main['category'] ?? 'Special' }}</span>
            </div>
        @endif

        {{-- === Hero caption (frosted glass overlay) === --}}
        @if ($main)
            <div class="absolute bottom-4 left-4 right-4">
                <div
                    class="hp-card rounded-2xl p-4 backdrop-blur-xl 
                        bg-gradient-to-br from-black/60 via-black/40 to-transparent
                        border border-white/10 
                        shadow-[0_4px_30px_rgba(0,0,0,0.4)]
                        transition-all duration-500 hover:shadow-[0_8px_40px_rgba(255,215,0,0.3)]">
                    <p class="hp-caption text-amber-200 mb-1 flex items-center gap-1 ">
                        <i data-lucide="star" class="w-4 h-4 text-yellow-300"></i>
                        <span data-vi="Món đặc biệt" data-en="Special dish"></span>
                    </p>
                    <p class="hp-subtitle text-xl font-semibold text-amber-50 drop-shadow-[0_1px_4px_rgba(0,0,0,0.8)]">
                        {{ $main['name'] }}
                    </p>
                    @if (!empty($main['description']))
                        <p class="text-sm text-stone-100/80 mt-1 ">
                            {{ Str::limit($main['description'], 80) }}
                        </p>
                    @endif
                </div>
            </div>
        @endif
    </div>

    {{-- === Thumbnail gallery (3 featured) === --}}
    <div class="mt-6 grid grid-cols-3 gap-4">
        @foreach ($featured as $index => $item)
            @if ($index <= 2)
                <div class="relative group/thumb rounded-xl overflow-hidden">
                    <x-fallback-image 
                        src="{{ $item['image'] ?? '/images/fallback-drink.jpg' }}"
                        alt="{{ $item['name'] }}"
                        class="h-28 w-full object-cover transition-all duration-700 group-hover/thumb:scale-105" />

                    {{-- === Fancy category badge (soft & readable) === --}}
                    <div
                        class="absolute top-2 left-2 flex items-center gap-1 px-2 py-0.5 rounded-full 
                            backdrop-blur-xl border border-white/20 
                            bg-gradient-to-r from-amber-500/40 via-orange-400/25 to-yellow-400/30
                            text-[11px] text-amber-50 font-semibold 
                            shadow-[0_0_10px_rgba(255,220,150,0.25)]">
                        <i data-lucide="cup-soda" class="w-3 h-3 text-amber-200"></i>
                        <span>{{ $item['category'] ?? 'Café' }}</span>
                    </div>

                    {{-- === Glassmorphism title overlay === --}}
                    <div
                        class="absolute bottom-0 left-0 right-0 p-3 
                            backdrop-blur-xl 
                            bg-gradient-to-t from-black/60 via-black/30 to-transparent
                            rounded-b-xl transition-all duration-500">
                        <p class="text-[13px] text-amber-50 font-semibold ">
                            {{ $item['name'] }}
                        </p>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
