<section class="mt-20 md:mt-24" wire:poll.30s="refresh">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- === Header === --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h3 class="hp-title hp-headline text-amber-200 mb-2">
                    <span data-vi="Đồ Uống Đặc Trưng" data-en="Featured Drinks"></span>
                </h3>
                <p class="text-stone-300/70"><span data-vi="Được chế biến theo công thức phép thuật cổ truyền" data-en="Crafted with ancient magical recipes"></span></p>
            </div>
        </div>

        {{-- === Featured Menu Grid === --}}
        <div class="overflow-hidden">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 transition-transform duration-700 ease-out"
                style="transform: translateX(-{{ $slide * 100 }}%);">

                @foreach ($featured as $index => $item)
                    <div class="hp-card rounded-2xl overflow-hidden group hp-hover">
                        <div class="aspect-[4/3] relative overflow-hidden">
                            <x-fallback-image src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-700" />

                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent">
                            </div>
                            <div class="absolute top-3 left-3">
                                <span
                                    class="hp-caption rounded-full bg-black/60 backdrop-blur-sm text-amber-200 px-3 py-1 border border-amber-400/30 flex items-center gap-1">
                                    <i data-lucide="cup-soda" class="w-4 h-4 text-amber-300"></i>
                                    {{ $item['category'] }}
                                </span>
                            </div>
                        </div>

                        {{-- === Content === --}}
                        <div class="p-6">
                            <div class="flex items-start justify-between gap-3 mb-4">
                                <div>
                                    <h4 class="hp-subtitle text-amber-100 font-semibold text-lg mb-1">
                                        {{ $item['name'] }}
                                    </h4>
                                    <p class="text-stone-300/80 text-sm leading-relaxed">
                                        {{ $item['description'] }}
                                    </p>
                                </div>
                                <span class="hp-subtitle text-amber-300 font-bold text-lg whitespace-nowrap">
                                    {{ $item['price'] }}
                                </span>
                            </div>

                            {{-- === Availability notice === --}}
                            <div class="flex items-center justify-center gap-2 mt-2">
                                <i data-lucide="store" class="w-4 h-4 text-amber-300"></i>
                                <p class="text-amber-200/80 text-sm font-medium tracking-wide">
                                    <span data-vi="Phục vụ tại quán" data-en="Served at the café"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- === Divider === --}}
            <div class="mt-8 h-px hp-divider"></div>
        </div>
    </div>
</section>
