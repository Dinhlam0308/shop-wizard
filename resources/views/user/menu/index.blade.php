<x-app-layout>

    <x-slot name="header">
        {{-- Tiêu đề --}}
        <header class="text-center mb-4 space-y-3">
            <h2
                class="flex justify-center items-center gap-3 text-4xl md:text-5xl 
                font-[Playfair_Display] font-semibold tracking-tight 
                text-transparent bg-clip-text bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500">
                <i data-lucide="cup-soda" class="w-8 h-8 text-amber-400 animate-pulse"></i>
                <span data-vi="Magic Menu" data-en="Magic Menu"></span>
                <i data-lucide="sparkles" class="w-8 h-8 text-yellow-300 animate-pulse"></i>
            </h2>
            <p class="text-gray-300 max-w-xl mx-auto text-base md:text-lg leading-relaxed">
                <span data-vi="Nơi hương vị cổ điển gặp gỡ phép màu hiện đại ✨"
                    data-en="Where classic flavors meet modern magic ✨"></span>
            </p>
        </header>
    </x-slot>
    {{-- ========================= --}}
    {{-- HERO SLIDER: is_special == 1 --}}
    {{-- ========================= --}}
    <section class="max-w-7xl mx-auto px-6">
        <div
            class="relative rounded-[32px] overflow-hidden border border-white/10 bg-white/5 backdrop-blur-2xl shadow-[0_20px_80px_rgba(0,0,0,0.35)]">
            <div
                class="absolute inset-0 pointer-events-none bg-gradient-to-br from-amber-400/10 via-white/5 to-transparent">
            </div>

            <div class="swiper heroSwiper">
                <div class="swiper-wrapper">
                    @forelse($specials as $item)
                        @php
                            $imageUrl = $item->image
                                ? (\Illuminate\Support\Str::startsWith($item->image, ['http://', 'https://'])
                                    ? $item->image
                                    : asset('storage/' . $item->image))
                                : '/images/default-drink.jpg';
                        @endphp

                        <div class="swiper-slide">
                            <div class="relative overflow-hidden rounded-3xl bg-black/20 w-full"
                                style="aspect-ratio: 1443 / 2048;">
                                <img src="{{ $imageUrl }}" alt="{{ $item->name }}"
                                    class="absolute inset-0 w-full h-full object-cover object-top" loading="lazy"
                                    decoding="async" />

                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent">
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-10 text-center text-white/70">
                            <span data-vi="Chưa có món is_special!" data-en="No is_special items!"></span>
                        </div>
                    @endforelse
                </div>
                <div class="heroPrev"></div>
                <div class="heroNext"></div>
                <div class="heroPagination swiper-pagination"></div>
                <div class="featuredPagination swiper-pagination mt-4"></div>
            </div>
        </div>
    </section>

    {{-- spacing --}}
    <div class="h-10"></div>

    {{-- ========================= --}}
    {{-- FEATURED CAROUSEL: is_featured == 1 --}}
    {{-- ========================= --}}
    <section class="max-w-7xl mx-auto px-6">
        <div class="flex items-end justify-between mb-4">
            <div>
                <h4 class="text-xl md:text-2xl font-[Playfair_Display] font-semibold text-white/90">
                    <span data-vi="Gợi ý nổi bật" data-en="Featured Picks"></span>
                </h4>
                <p class="text-sm text-white/60 mt-1">
                    <span data-vi="Trượt để xem thêm" data-en="Swipe to explore more"></span>
                </p>
            </div>
        </div>

        <div class="swiper featuredSwiper">
            <div class="swiper-wrapper">
                @forelse($featured as $item)
                    @php
                        $imageUrl = $item->image
                            ? (\Illuminate\Support\Str::startsWith($item->image, ['http://', 'https://'])
                                ? $item->image
                                : asset('storage/' . $item->image))
                            : '/images/default-drink.jpg';
                    @endphp

                    <div class="swiper-slide">
                        <article
                            class="group rounded-3xl overflow-hidden border border-white/10 bg-white/5 backdrop-blur-2xl
                                    shadow-[0_10px_40px_rgba(0,0,0,0.25)]
                                    hover:shadow-[0_18px_70px_rgba(255,215,0,0.15)]
                                    transition-all duration-500">
                            <div class="relative overflow-hidden rounded-3xl bg-black/20 w-full"
                                style="aspect-ratio: 1443 / 2048;">

                                <img src="{{ $imageUrl }}" alt="{{ $item->name }}"
                                    class="absolute inset-0 w-full h-full object-cover object-center
                transition-transform duration-700 group-hover:scale-110"
                                    loading="lazy" decoding="async" />

                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/55 via-black/10 to-transparent">
                                </div>

                                <div class="absolute left-4 right-4 bottom-4">
                                    <h5 class="text-base font-semibold text-white line-clamp-1">
                                        {{ $item->name }}
                                    </h5>

                                    <div class="mt-2 flex items-center justify-between">
                                        <span class="text-amber-200 font-semibold text-sm">
                                            {{ number_format($item->price, 2) }}₫
                                        </span>

                                        @if ($item->available)
                                            <i data-lucide="check-circle" class="w-5 h-5 text-emerald-300"></i>
                                        @else
                                            <i data-lucide="x-circle" class="w-5 h-5 text-rose-300"></i>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="p-10 text-center text-white/70">
                        <span data-vi="Chưa có món is_featured!" data-en="No is_featured items!"></span>
                    </div>
                @endforelse
            </div>

            <div class="featuredPagination mt-4"></div>
        </div>
    </section>

    <script>
        lucide.createIcons();
    </script>
</x-app-layout>
