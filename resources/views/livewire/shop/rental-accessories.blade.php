<section class="mt-20 md:mt-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-3 gap-8">

        {{-- === COSTUME RENTAL === --}}
        <div class="lg:col-span-2 hp-card rounded-3xl p-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="hp-title hp-headline text-amber-200 mb-2">
                        <span data-vi="Trang Phục Cosplay" data-en="Cosplay Costumes"></span>
                    </h3>
                    <p class="text-stone-300/70 text-sm"><span data-vi="Trang phục cosplay chất lượng cao"
                            data-en="High-quality cosplay costumes"></span></p>
                </div>
                <a href="{{ route('user.shop.rental') }}"
                    class="text-amber-200/80 hover:text-amber-200 text-sm font-medium transition-colors">
                    <span data-vi="Xem bộ sưu tập" data-en="View Collection"></span>
                    <i data-lucide="arrow-big-right-dash" class="w-4 h-4 inline-block"></i>
                </a>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($rentals as $r)
                    <div class="hp-card rounded-2xl overflow-hidden hp-hover group">
                        <div class="aspect-[3/4] relative overflow-hidden">
                            <x-fallback-image src="{{ $r['image'] }}" alt="{{ $r['name'] }}"
                                class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-700" />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                        </div>
                        <div class="p-5">
                            <h4 class="hp-subtitle text-amber-100 font-semibold mb-1">{{ $r['name'] }}</h4>
                            <p class="text-stone-300/60 text-xs mb-2">{{ $r['description'] }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-amber-300 font-bold">{{ $r['price'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- === ACCESSORIES === --}}
        <div
            class="hp-card rounded-3xl p-8 backdrop-blur-xl bg-gradient-to-br from-stone-900/70 via-black/60 to-stone-950/70 border border-amber-400/10 shadow-[0_0_30px_rgba(255,215,0,0.05)]">
            {{-- Header --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="hp-title hp-headline text-amber-200 mb-2"><span data-vi="Phụ Kiện Nổi Bật"
                            data-en="Featured Accessories"></span></h3>
                    <p class="text-stone-300/70 text-sm"><span data-vi="Phụ kiện phép thuật chính hãng"
                            data-en="Authentic magical accessories"></span></p>
                </div>

                <a href="{{ route('user.shop.accessories') }}"
                    class="inline-flex items-center text-amber-200/80 hover:text-amber-200 text-sm font-medium transition-colors group">
                    <span data-vi="Cửa hàng" data-en="Shop"></span>
                    <i data-lucide="arrow-big-right-dash"
                        class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform duration-300"></i>
                </a>
            </div>

            {{-- Accessories List --}}
            <div class="space-y-4">
                @foreach ($accessories as $a)
                    <div
                        class="flex items-center justify-between hp-card rounded-2xl p-4 backdrop-blur-md bg-stone-900/40 border border-amber-400/10 hover:border-amber-300/30 transition-all duration-500 hover:scale-[1.02] group">
                        {{-- Left section --}}
                        <div class="pr-3">
                            <h4 class="text-amber-100 font-semibold text-sm">{{ $a['name'] }}</h4>
                            <p class="text-stone-300/60 text-xs mt-1 leading-snug">
                                {{ Str::limit($a['description'], 60) }}</p>
                        </div>

                        {{-- Right section --}}
                        <div class="text-right">
                            <span class="hp-subtitle text-amber-300 font-bold block mb-1">
                                {{ number_format($a->price, 0, ',', '.') }}₫
                            </span>

                            @php
                                $hasVariants = $a->variants && $a->variants->count() > 0;
                                $outOfStock = (int) ($a->stock ?? 0) <= 0;
                            @endphp

                            {{-- Nếu có variant -> chuyển sang detail --}}
                            @if ($hasVariants)
                                <a href="{{ route('user.product.show', $a->id) }}"
                                    class="text-xs text-amber-200/70 hover:text-amber-100 opacity-0 group-hover:opacity-100
                  transition-all duration-300 hover:underline">
                                    <span data-vi="Xem chi tiết" data-en="View details"></span>
                                </a>

                                {{-- Không có variant -> add to cart, nhưng hết hàng thì disable --}}
                            @else
                                <form action="{{ route('cart.add', $a->id) }}" method="POST" class="inline">
                                    @csrf

                                    <button type="submit" x-data="loadingButton" @click="handleClick" data-loading
                                        @disabled($outOfStock)
                                        class="text-xs opacity-0 group-hover:opacity-100 transition-all duration-300 hover:underline
                       {{ $outOfStock
                           ? 'text-stone-500 cursor-not-allowed opacity-60 pointer-events-none'
                           : 'text-amber-200/70 hover:text-amber-100' }}">
                                        @if ($outOfStock)
                                            <span data-vi="Hết hàng" data-en="Out of stock"></span>
                                        @else
                                            <span data-vi="Thêm vào giỏ" data-en="Add to Cart"></span>
                                        @endif
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
