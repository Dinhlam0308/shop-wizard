<x-app-layout>
    <x-slot name="header">
        {{-- Header --}}
        <header class="text-center mb-6 space-y-3">
            <h2
                class="flex justify-center items-center gap-3 text-4xl md:text-5xl
                font-[Playfair_Display] font-semibold tracking-tight
                text-transparent bg-clip-text bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500">
                <i data-lucide="cup-soda" class="w-8 h-8 text-amber-400 animate-pulse"></i>
                <span data-vi="Magic Menu" data-en="Magic Menu"></span>
                <i data-lucide="sparkles" class="w-8 h-8 text-yellow-300 animate-pulse"></i>
            </h2>

            <p class="text-gray-300 max-w-xl mx-auto text-base md:text-lg leading-relaxed">
                <span data-vi="Nơi hương vị cổ điển gặp gỡ phép màu hiện đại"
                    data-en="Where classic flavors meet modern magic"></span>
            </p>
        </header>
    </x-slot>

    {{-- ========================= --}}
    {{-- APPLE 2-COLUMN LAYOUT --}}
    {{-- ========================= --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">

            {{-- LEFT: HERO MENU IMAGES (ONLY IMAGE) --}}
            <div class="lg:col-span-5 xl:col-span-5">
                <div
                    class="relative rounded-[28px] sm:rounded-[32px] overflow-hidden
                    border border-white/10 bg-white/5 backdrop-blur-2xl
                    shadow-[0_20px_80px_rgba(0,0,0,0.35)]">

                    {{-- subtle overlay --}}
                    <div
                        class="absolute inset-0 pointer-events-none bg-gradient-to-br from-amber-400/10 via-white/5 to-transparent">
                    </div>

                    {{-- swipe hint --}}
                    <div class="absolute z-20 top-4 left-4">
                        <span
                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full
                            bg-black/35 border border-white/10 backdrop-blur-md text-white/85 text-xs">
                            <i data-lucide="hand" class="w-4 h-4 text-amber-200"></i>
                            <span data-vi="Trượt để xem" data-en="Swipe to browse"></span>
                        </span>
                    </div>

                    <div class="swiper heroSwiper" aria-label="Menu images slider">
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
                                    {{-- ONLY IMAGE --}}
                                    <div class="relative overflow-hidden bg-black/20 w-full"
                                        style="aspect-ratio: 1443 / 2048;">
                                        <img src="{{ $imageUrl }}" alt="Menu image"
                                            class="absolute inset-0 w-full h-full object-cover object-top"
                                            loading="lazy" decoding="async" />
                                        {{-- add very light vignette to feel premium --}}
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/25 via-transparent to-transparent">
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-10 text-center text-white/70">
                                    <span data-vi="Chưa có ảnh menu!" data-en="No menu images yet!"></span>
                                </div>
                            @endforelse
                        </div>

                        {{-- Controls --}}
                        <button class="heroPrev" type="button" aria-label="Previous slide"></button>
                        <button class="heroNext" type="button" aria-label="Next slide"></button>
                        <div class="heroPagination swiper-pagination"></div>
                    </div>
                </div>
            </div>

            {{-- RIGHT: FEATURED (NAME + PRICE) --}}
            <aside class="lg:col-span-7 xl:col-span-7">
                <div class="lg:sticky lg:top-24 space-y-4">
                    <div>

                        <div class="swiper featuredSwiper p-4 sm:p-5" aria-label="Featured items slider">
                            <div class="swiper-wrapper">
                                @forelse($featured as $item)
                                    @php
                                        $imageUrl = $item->image
                                            ? (\Illuminate\Support\Str::startsWith($item->image, [
                                                'http://',
                                                'https://',
                                            ])
                                                ? $item->image
                                                : asset('storage/' . $item->image))
                                            : '/images/default-drink.jpg';
                                    @endphp

                                    <div class="swiper-slide">
                                        {{-- Apple list-card style --}}
                                        <article
                                            class="group rounded-3xl overflow-hidden
                                            border border-white/10 bg-white/5
                                            shadow-[0_10px_40px_rgba(0,0,0,0.25)]
                                            hover:shadow-[0_18px_70px_rgba(255,215,0,0.12)]
                                            transition-[transform,box-shadow] duration-500 ease-out
                                            hover:-translate-y-[2px]">

                                            {{-- top image small (optional nhưng Apple rất hay dùng) --}}
                                            <div class="relative overflow-hidden bg-black/20 w-full"
                                                style="aspect-ratio: 10 / 14;">
                                                <img src="{{ $imageUrl }}" alt="{{ $item->name }}"
                                                    class="absolute inset-0 w-full h-full object-cover object-center
                                                     transition-transform duration-700 group-hover:scale-105"
                                                    loading="lazy" decoding="async" />
                                                <div
                                                    class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/10 to-transparent">
                                                </div>

                                                {{-- availability pill --}}
                                                <div class="absolute top-3 left-3">
                                                    @if ($item->available)
                                                        <span
                                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px]
                                                            bg-emerald-500/15 border border-emerald-400/25 text-emerald-200 backdrop-blur-md">
                                                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                                                            <span data-vi="Có sẵn" data-en="Available"></span>
                                                        </span>
                                                    @else
                                                        <span
                                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px]
                                                            bg-rose-500/15 border border-rose-400/25 text-rose-200 backdrop-blur-md">
                                                            <i data-lucide="x-circle" class="w-4 h-4"></i>
                                                            <span data-vi="Hết món" data-en="Sold out"></span>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- content: NAME + PRICE (RIGHT SIDE REQUIREMENT) --}}
                                            <div class="p-4">
                                                <div class="flex items-start justify-between gap-3">
                                                    <h5
                                                        class="text-[15px] sm:text-base font-semibold text-white/95 leading-snug line-clamp-2">
                                                        {{ $item->name }}
                                                    </h5>

                                                    {{-- price --}}
                                                    <div class="shrink-0 text-right">
                                                        <div
                                                            class="text-amber-200 font-bold text-sm sm:text-base leading-none">
                                                            {{ number_format($item->price, 0, ',', '.') }}₫
                                                        </div>
                                                        <div class="text-[11px] text-white/55 mt-1">
                                                            <span data-vi="Giá" data-en="Price"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- subtle divider --}}
                                                <div
                                                    class="mt-3 h-px bg-gradient-to-r from-transparent via-white/10 to-transparent">
                                                </div>

                                                {{-- micro action row --}}
                                                <div class="mt-3 flex items-center justify-between">
                                                    <span class="text-xs text-white/60">
                                                        <span data-vi="Gợi ý hôm nay" data-en="Today’s pick"></span>
                                                    </span>

                                                    <button type="button"
                                                        class="inline-flex items-center gap-2 px-3 py-2 rounded-full
                                                            bg-black/30 border border-white/10 backdrop-blur-md
                                                            text-white/85 text-xs
                                                            hover:bg-black/40 transition-colors
                                                            focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-300/60">
                                                        <i data-lucide="sparkles" class="w-4 h-4 text-amber-200"></i>
                                                        <span data-vi="Nổi bật" data-en="Featured"></span>
                                                    </button>
                                                </div>
                                            </div>

                                        </article>
                                    </div>
                                @empty
                                    <div class="p-10 text-center text-white/70">
                                        <span data-vi="Chưa có món nổi bật!" data-en="No featured items!"></span>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                </div>
            </aside>

        </div>
    </section>

    <script>
        lucide.createIcons();
    </script>
</x-app-layout>
