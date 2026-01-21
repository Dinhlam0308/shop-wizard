<x-app-layout>
    <x-slot name="header">
        <header class="text-center mb-12 space-y-3">
            <h2
                class="flex justify-center items-center gap-3 text-4xl md:text-5xl 
                font-[Playfair_Display] font-semibold tracking-tight 
                text-transparent bg-clip-text bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500">
                <i data-lucide="wand" class="w-8 h-8 text-amber-400 animate-pulse"></i>
                <span data-vi="Cửa hàng Phụ kiện" data-en="Accessories Shop"></span>
                <i data-lucide="sparkles" class="w-8 h-8 text-yellow-300 animate-pulse"></i>
            </h2>
            <p class="mt-4 text-gray-300 max-w-2xl mx-auto text-lg leading-relaxed">
                <span data-vi="Khám phá bộ sưu tập phụ kiện phép thuật độc đáo cho cuộc sống hàng ngày."
                    data-en="Discover a unique collection of magical accessories for everyday life."></span>
            </p>
        </header>
    </x-slot>

    {{-- === Khu vực chính (Magic Glass Section) === --}}
    <section class="relative max-w-7xl mx-auto px-6 font-[Inter] select-none">

        {{-- Danh mục sản phẩm --}}
        <div x-data="{ showAll: false }" x-init="$nextTick(() => lucide.createIcons())" class="text-center mb-10">
            <div class="flex flex-wrap justify-center gap-3 mb-6">
                {{-- Tất cả sản phẩm --}}
                <a href="{{ route('user.shop.accessories', ['category_id' => null]) }}"
                    class="flex items-center gap-2 px-5 py-2.5 rounded-full
                   {{ request('category_id') === null
                       ? 'bg-amber-400/20 border-amber-400 text-amber-300 scale-105 shadow-[0_0_20px_rgba(255,215,0,0.3)]'
                       : 'bg-gradient-to-r from-gray-900/70 to-gray-800/60 border border-amber-400/30 text-gray-100' }}
                   text-sm font-medium backdrop-blur-lg transition-all duration-500 hover:scale-[1.05]">
                    <i data-lucide="tags" class="w-4 h-4 text-amber-400"></i>
                    <span data-vi="Tất cả vật phẩm" data-en="All Items"></span>
                </a>

                {{-- Các danh mục khác --}}
                @foreach ($categories as $index => $cat)
                    <template x-if="showAll || {{ $index }} < 8">
                        <a href="{{ route('user.shop.accessories', ['category_id' => $cat->id]) }}"
                            class="flex items-center gap-2 px-5 py-2.5 rounded-full 
                   {{ request('category_id') == $cat->id
                       ? 'bg-amber-400/20 border-amber-400 text-amber-300 scale-105 shadow-[0_0_20px_rgba(255,215,0,0.3)]'
                       : 'bg-gradient-to-r from-gray-900/70 to-gray-800/60 border border-amber-400/30 text-gray-100' }}
                   text-sm font-medium backdrop-blur-lg transition-all duration-500 hover:scale-[1.05]">
                            <i data-lucide="tags" class="w-4 h-4 text-amber-400"></i>
                            {{ $cat->name }}
                        </a>
                    </template>
                @endforeach
            </div>

            {{-- Nút xem thêm / thu gọn --}}
            <button @click="showAll = !showAll; $nextTick(() => lucide.createIcons())"
                class="text-amber-400 hover:text-amber-300 font-medium text-sm 
               transition-colors duration-300 underline underline-offset-4">
                <span x-cloak x-show="!showAll">Xem thêm ↓</span>
                <span x-cloak x-show="showAll">Thu gọn ↑</span>
            </button>
        </div>

        {{-- Script khởi tạo icon --}}
        <script>
            lucide.createIcons();
        </script>

        {{-- Lưới sản phẩm --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse ($products as $product)
                @php
                    $image = $product->image
                        ? (Str::startsWith($product->image, ['http://', 'https://'])
                            ? $product->image
                            : asset('storage/' . $product->image))
                        : 'https://picsum.photos/600/400?random=' . rand(1, 1000);
                @endphp

                {{-- Thẻ sản phẩm --}}
                <article
                    class="group relative rounded-3xl overflow-hidden border 
                                border-white/15 dark:border-gray-700/40
                                bg-white/5 backdrop-blur-xl
                                shadow-[0_6px_30px_rgba(0,0,0,0.15)]
                                hover:shadow-[0_12px_40px_rgba(212,175,55,0.25)]
                                hover:border-amber-400/30 hover:-translate-y-1
                                transition-all duration-700 ease-[cubic-bezier(0.23,1,0.32,1)]">

                    {{-- Hình ảnh --}}
                    <div class="aspect-[4/3] overflow-hidden relative">

                        @if ($product->variants->count() > 0)
                            <span
                                class="absolute top-3 left-3 text-[10px] px-2 py-1 rounded-full
                 bg-indigo-500/80 text-white backdrop-blur">
                                Multiple options
                            </span>
                        @endif
                        <a href="{{ route('user.product.show', $product->id) }}" class="block w-full h-full">
                            <img src="{{ $image }}" alt="{{ $product->name }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-700">
                            </div>
                        </a>
                    </div>

                    {{-- Nội dung --}}
                    <div class="p-6 flex flex-col justify-between h-[240px]">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-100 mb-2 line-clamp-2">
                                {{ $product->name }}
                            </h3>
                            <p class="text-gray-400 text-sm line-clamp-2">
                                {{ $product->description ?? 'Một sản phẩm tuyệt vời dành cho thú cưng của bạn.' }}
                            </p>
                        </div>

                        <div class="mt-4 flex items-end justify-between">
                            <div>
                                <div class="text-xs text-gray-400">Giá bán</div>
                                <div
                                    class="text-2xl font-bold bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">
                                    {{ number_format($product->price, 0, ',', '.') }}₫
                                </div>
                            </div>

                            @if ($product->variants && $product->variants->count() > 0)
                                <a href="{{ route('user.product.show', $product->id) }}"
                                    class="px-4 py-2 rounded-xl text-sm text-gray-900
                  bg-gradient-to-r from-sky-300 via-indigo-400 to-purple-500
                  shadow-[0_4px_20px_rgba(99,102,241,0.25)]
                  hover:shadow-[0_6px_30px_rgba(99,102,241,0.35)]
                  hover:scale-[1.03]
                  transition-all duration-300 ease-out">
                                    View Details
                                </a>
                            @else
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf

                                    <button type="submit" x-data="loadingButton" @click="handleClick" data-loading
                                        @disabled($product->stock <= 0)
                                        class="
            px-4 py-2 rounded-xl text-sm
            transition-all duration-300 ease-out

            {{ $product->stock <= 0
                ? 'bg-gray-500 text-gray-300 cursor-not-allowed'
                : 'text-gray-900 bg-gradient-to-r from-amber-300 via-amber-400 to-yellow-500
                                           shadow-[0_4px_20px_rgba(212,175,55,0.25)]
                                           hover:shadow-[0_6px_30px_rgba(212,175,55,0.35)]
                                           hover:scale-[1.03]' }}
        ">
                                        {{ $product->stock <= 0 ? 'Out of Stock' : 'Add to Cart' }}
                                    </button>
                                </form>
                            @endif
                        </div>

                    </div>
                </article>
            @empty
                <div class="col-span-full text-center text-gray-400">
                    <span data-vi="Hiện chưa có phụ kiện nào trong danh mục này."
                        data-en="No accessories available in this category."></span>
                </div>
            @endforelse
        </div>
        <div class="text-center mt-10">
            <p class="flex items-center justify-center gap-2 text-sm text-gray-400/90 italic">
                <i data-lucide="info" class="w-4 h-4 text-amber-400/90"></i>
                <span data-vi="Vật phẩm cho thuê có thể đặt trực tiếp qua giỏ hàng."
                    data-en="Rental items can be booked directly through the cart.">
                </span>
            </p>
        </div>

        {{-- Phân trang --}}
        <div>
            {{ $products->links('components.pagination_magical') }}
        </div>
    </section>

    {{-- === Hiệu ứng ánh sáng bay quanh (Ambient Particles) === --}}
    <div class="pointer-events-none fixed inset-0 overflow-hidden">
        <div class="absolute -top-10 -left-10 w-4 h-4 bg-amber-400/30 rounded-full animate-pulse"></div>
        <div
            class="absolute top-1/3 right-10 w-3 h-3 bg-yellow-200/20 rounded-full animate-[fade-in_3s_infinite_alternate]">
        </div>
        <div
            class="absolute bottom-16 left-1/2 w-2 h-2 bg-amber-300/30 rounded-full animate-[float_6s_ease-in-out_infinite]">
        </div>
    </div>
</x-app-layout>
