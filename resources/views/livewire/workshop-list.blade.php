<div class="rounded-3xl p-8 max-w-7xl mx-auto" wire:poll.30s="refresh">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="hp-title hp-headline text-amber-200 mb-2"><span data-vi="Workshop Sắp Diễn Ra" data-en="Upcoming Workshops"></span></h3>
            <p class="text-stone-300/70 text-sm"><span data-vi="Học hỏi và sáng tạo cùng các chuyên gia" data-en="Learn and create with experts"></span></p>
        </div>

        <a href="{{ route('user.workshops.index') }}"
            class="text-amber-200/80 hover:text-amber-200 text-sm font-medium transition-colors flex items-center gap-1">
            <span data-vi="Xem tất cả" data-en="View All"></span>
            <x-lucide-arrow-big-right-dash class="w-4 h-4" />
        </a>
    </div>

    {{-- === Workshop list === --}}
    <div class="space-y-4">
        @forelse ($workshops as $w)
            <a href="{{ route('user.workshop.show', $w->id) }}"
                class="flex items-center gap-6 hp-card rounded-2xl p-5 hp-hover group">
                <x-fallback-image src="{{ $w->image ?? '/images/workshop-ink.jpg' }}"
                    class="h-20 w-20 object-cover rounded-xl flex-shrink-0" alt="{{ $w->title }}" />
                <div class="min-w-0 flex-1">
                    <h4 class="hp-subtitle text-amber-100 font-semibold mb-1 truncate">
                        {{ $w->title }}
                    </h4>
                    <p class="text-stone-300/80 text-sm mb-2">
                        {{ \Illuminate\Support\Carbon::parse($w->date . ' ' . $w->time)->format('d/m/Y • H:i') }}
                    </p>
                    <p class="text-stone-400/70 text-xs">{{ $w->location }}</p>
                </div>

                <div
                    class="hp-btn-primary rounded-xl px-4 py-2 text-sm font-semibold flex items-center gap-2 group-hover:scale-105 transition-transform">
                    <i data-lucide="ticket" class="w-4 h-4"></i>
                    <span data-vi="Đăng ký" data-en="Register"></span>
                </div>
            </a>
        @empty
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-amber-400/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-amber-400/50" fill="none"
                        stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-stone-300/60 text-sm"><span data-vi="Workshop mới đang được chuẩn bị..." data-en="New workshops are being prepared..."></span></p>
                <p class="text-stone-400/50 text-xs mt-1"><span data-vi="Hãy theo dõi để không bỏ lỡ!" data-en="Follow us to not miss out!"></span></p>
            </div>
        @endforelse
    </div>
</div>
