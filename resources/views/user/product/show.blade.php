{{-- resources/views/user/product/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="flex items-center justify-between
                       bg-white/80 dark:bg-gray-800/70 backdrop-blur-xl
                       border border-gray-200/70 dark:border-gray-700/60
                       rounded-2xl px-5 py-4 shadow-[0_20px_60px_-35px_rgba(0,0,0,0.35)]">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/15 grid place-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-amber-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-gray-100">
                            {{ $product->name }}
                        </h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Product details
                        </p>
                    </div>
                </div>

                <a href="{{ url()->previous() }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold
                          px-4 py-2 rounded-full
                          bg-gray-900/5 dark:bg-white/10
                          hover:bg-gray-900/10 dark:hover:bg-white/15
                          text-gray-900 dark:text-gray-100 transition">
                    <span>Back</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-950 dark:to-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Breadcrumb --}}
            <nav class="text-sm mb-6">
                <ol class="flex flex-wrap items-center gap-2 text-gray-500 dark:text-gray-400">
                    <li><a class="hover:text-amber-400" href="{{ route('dashboard') }}">Home</a></li>
                    <li class="opacity-60">/</li>

                    @if ($product->is_rental)
                        <li><a class="hover:text-amber-400" href="{{ route('user.shop.rental') }}">Rental</a></li>
                    @else
                        <li><a class="hover:text-amber-400" href="{{ route('user.shop.accessories') }}">Accessories</a>
                        </li>
                    @endif

                    <li class="opacity-60">/</li>
                    <li class="text-gray-900 dark:text-gray-100 font-medium line-clamp-1">{{ $product->name }}</li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8" x-data="productShowPage({
                mainImage: @js($product->image),
                gallery: @js(($product->images ?? collect())->pluck('image_url')),
                basePrice: @js((float) $product->price),
                baseStock: @js((int) $product->stock),
                isRental: @js((int) $product->is_rental),
                variants: @js(
    ($product->variants ?? collect())
        ->map(
            fn($v) => [
                'id' => $v->id,
                'color' => $v->color,
                'size' => $v->size,
                'price' => $v->price,
                'stock' => (int) $v->stock,
            ],
        )
        ->values(),
),
            })" x-init="init()">

                {{-- LEFT: Gallery --}}
                <div class="lg:col-span-7">
                    <div
                        class="relative overflow-hidden rounded-3xl
                               border border-gray-200/70 dark:border-gray-800/70
                               bg-white/60 dark:bg-gray-900/40 backdrop-blur-xl
                               shadow-[0_20px_70px_-40px_rgba(0,0,0,0.45)]">

                        {{-- Main Image --}}
                        <div class="relative aspect-[4/3] bg-gray-100 dark:bg-gray-900">
                            <img :src="active" alt="Product image" class="w-full h-full object-cover"
                                @click="openLightbox(active)" loading="lazy" />

                            {{-- soft gradient --}}
                            <div
                                class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/30 via-black/0 to-black/0">
                            </div>

                            {{-- Tag --}}
                            <div class="absolute top-4 left-4">
                                @if ($product->is_rental)
                                    <span
                                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold
                                                 bg-indigo-500/15 text-indigo-300 border border-indigo-400/20">
                                        Rental
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold
                                                 bg-emerald-500/15 text-emerald-300 border border-emerald-400/20">
                                        Accessories
                                    </span>
                                @endif
                            </div>

                            {{-- Zoom hint --}}
                            <button type="button"
                                class="absolute bottom-4 right-4
                                           inline-flex items-center gap-2
                                           px-3 py-2 rounded-full text-xs font-semibold
                                           bg-white/70 dark:bg-gray-900/60
                                           border border-white/50 dark:border-gray-700/60
                                           text-gray-900 dark:text-gray-100
                                           hover:bg-white/90 dark:hover:bg-gray-900/80 transition"
                                @click="openLightbox(active)">
                                View
                            </button>
                        </div>

                        {{-- Thumbs --}}
                        <div class="p-4">
                            <div class="flex gap-3 overflow-x-auto pb-1">
                                <template x-for="(img, idx) in allImages" :key="idx">
                                    <button type="button"
                                        class="relative shrink-0 w-20 h-20 rounded-2xl overflow-hidden
                                                   border transition
                                                   hover:scale-[1.02]"
                                        :class="active === img ? 'border-amber-400 ring-2 ring-amber-400/25' :
                                            'border-gray-200/70 dark:border-gray-800/70'"
                                        @click="active = img">
                                        <img :src="img" class="w-full h-full object-cover" loading="lazy" />
                                    </button>
                                </template>
                            </div>

                            {{-- If no gallery --}}
                            @if (($product->images ?? collect())->count() === 0)
                                <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">
                                    No additional gallery images.
                                </p>
                            @endif
                        </div>
                    </div>

                    {{-- Description card --}}
                    <div
                        class="mt-6 rounded-3xl border border-gray-200/70 dark:border-gray-800/70
                                bg-white/60 dark:bg-gray-900/40 backdrop-blur-xl
                                shadow-[0_20px_70px_-45px_rgba(0,0,0,0.35)] p-6">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-3">
                            Description
                        </h3>

                        @if (!empty($product->description))
                            <div class="prose prose-sm dark:prose-invert max-w-none">
                                {!! nl2br(e($product->description)) !!}
                            </div>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                No description provided.
                            </p>
                        @endif
                    </div>
                </div>

                {{-- RIGHT: Info/CTA --}}
                <div class="lg:col-span-5">
                    <div
                        class="sticky top-24 rounded-3xl border border-gray-200/70 dark:border-gray-800/70
                               bg-white/70 dark:bg-gray-900/45 backdrop-blur-xl
                               shadow-[0_25px_80px_-50px_rgba(0,0,0,0.5)] p-6">

                        {{-- Title --}}
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h1 class="text-xl sm:text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $product->name }}
                                </h1>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    @if ($product->category)
                                        Category: <span
                                            class="text-gray-900 dark:text-gray-100 font-medium">{{ $product->category->name }}</span>
                                    @else
                                        Category: <span
                                            class="text-gray-900 dark:text-gray-100 font-medium">Uncategorized</span>
                                    @endif
                                </p>
                            </div>

                            {{-- Stock badge --}}
                            <div class="shrink-0">
                                <template x-if="displayStock > 0">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                     bg-emerald-500/15 text-emerald-300 border border-emerald-400/20">
                                        In stock: <span class="ml-1" x-text="displayStock"></span>
                                    </span>
                                </template>

                                <template x-if="displayStock <= 0">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                     bg-rose-500/15 text-rose-300 border border-rose-400/20">
                                        Out of stock
                                    </span>
                                </template>
                            </div>
                        </div>

                        {{-- Price --}}
                        <div
                            class="mt-6 rounded-2xl p-4
                                    bg-gradient-to-br from-amber-500/15 via-white/0 to-indigo-500/10
                                    border border-white/40 dark:border-gray-800/60">
                            <div class="flex items-end justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">
                                        @if ($product->is_rental)
                                            Rental price
                                        @else
                                            Price
                                        @endif
                                    </p>
                                    <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                        <span x-text="formatVND(displayPrice)"></span>
                                    </p>
                                </div>

                                <button type="button"
                                    class="text-xs font-semibold px-3 py-2 rounded-full
                                               bg-gray-900/5 dark:bg-white/10
                                               hover:bg-gray-900/10 dark:hover:bg-white/15
                                               text-gray-900 dark:text-gray-100 transition"
                                    @click="copyText('{{ $product->name }}')">
                                    Copy name
                                </button>
                            </div>

                            @if ($product->is_rental)
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                    Rental terms may apply at checkout.
                                </p>
                            @endif
                        </div>

                        {{-- Quick meta --}}
                        <div class="mt-6 grid grid-cols-2 gap-3 text-sm">
                            <div
                                class="rounded-2xl border border-gray-200/70 dark:border-gray-800/70 p-4 bg-white/60 dark:bg-gray-900/35">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Product ID</p>
                                <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">#{{ $product->id }}</p>
                            </div>
                            <div
                                class="rounded-2xl border border-gray-200/70 dark:border-gray-800/70 p-4 bg-white/60 dark:bg-gray-900/35">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Type</p>
                                <p class="mt-1 font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $product->is_rental ? 'Rental' : 'Accessories' }}
                                </p>
                            </div>
                        </div>

                        {{-- Variant picker (only if has variants) --}}
                        <div x-show="hasVariants" x-transition.opacity class="mt-6 space-y-3">
                            <div
                                class="rounded-2xl border border-gray-200/70 dark:border-gray-800/70 p-4 bg-white/60 dark:bg-gray-900/35">
                                <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">Choose variant</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    Select color & size to see exact price/stock.
                                </p>

                                {{-- Color --}}
                                <div class="mt-4">
                                    <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Color</label>
                                    <select x-model="selectedColor"
                                        class="mt-2 w-full px-3 py-3 rounded-2xl border border-gray-200/70 dark:border-gray-800/70
                           bg-white/70 dark:bg-gray-900/40 text-gray-900 dark:text-gray-100
                           focus:ring-2 focus:ring-amber-400/40 focus:border-amber-400/40 outline-none">
                                        <template x-for="c in colors" :key="c">
                                            <option :value="c" x-text="c"></option>
                                        </template>
                                    </select>
                                </div>

                                {{-- Size --}}
                                <div class="mt-4">
                                    <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Size</label>
                                    <select x-model="selectedSize"
                                        class="mt-2 w-full px-3 py-3 rounded-2xl border border-gray-200/70 dark:border-gray-800/70
                           bg-white/70 dark:bg-gray-900/40 text-gray-900 dark:text-gray-100
                           focus:ring-2 focus:ring-amber-400/40 focus:border-amber-400/40 outline-none">
                                        <template x-for="s in sizesForSelectedColor" :key="s">
                                            <option :value="s" x-text="s"></option>
                                        </template>
                                    </select>
                                </div>

                                {{-- Variant status --}}
                                <div class="mt-4 flex items-center justify-between">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        Variant stock:
                                        <span class="font-semibold text-gray-900 dark:text-gray-100"
                                            x-text="variantStock"></span>
                                    </p>
                                    <template x-if="!selectedVariant">
                                        <span class="text-xs font-semibold text-rose-400">Select a valid variant</span>
                                    </template>
                                </div>
                            </div>
                        </div>

                        {{-- CTA --}}
                        <div class="mt-6 space-y-3">
                            @if ((int) $product->stock > 0)
                                <form method="POST" action="{{ route('cart.add', $product->id) }}" class="w-full">
                                    @csrf
                                    <input type="hidden" name="variant_id"
                                        :value="selectedVariant ? selectedVariant.id : ''">

                                    <div class="flex gap-3">
                                        <div class="w-28">
                                            <label class="sr-only">Qty</label>
                                            <input type="number" name="qty" min="1" value="1"
                                                class="w-full text-center px-3 py-3 rounded-2xl
                                                          border border-gray-200/70 dark:border-gray-800/70
                                                          bg-white/70 dark:bg-gray-900/40
                                                          text-gray-900 dark:text-gray-100
                                                          focus:ring-2 focus:ring-amber-400/40 focus:border-amber-400/40 outline-none">
                                        </div>

                                        <button type="submit"
                                            :disabled="hasVariants && (!selectedVariant || variantStock <= 0)"
                                            x-data="loadingButton" @click="handleClick" data-loading
                                            class="flex-1 inline-flex items-center justify-center gap-2
                                                       px-5 py-3 rounded-2xl font-semibold
                                                       bg-gradient-to-r from-amber-500 via-orange-500 to-rose-500
                                                       text-white shadow-[0_18px_55px_-25px_rgba(0,0,0,0.55)]
                                                       hover:brightness-[1.05] active:scale-[0.99] transition">
                                            @if ($product->is_rental)
                                                Rent now
                                            @else
                                                Add to cart
                                            @endif
                                        </button>
                                    </div>
                                </form>
                            @else
                                <button type="button" disabled
                                    class="w-full px-5 py-3 rounded-2xl font-semibold
                                               bg-gray-300 dark:bg-gray-800 text-gray-700 dark:text-gray-400
                                               cursor-not-allowed">
                                    Unavailable
                                </button>
                            @endif

                            <div class="flex gap-3">
                                <button type="button"
                                    class="flex-1 px-4 py-3 rounded-2xl text-sm font-semibold
                                               bg-white/70 dark:bg-gray-900/40
                                               border border-gray-200/70 dark:border-gray-800/70
                                               text-gray-900 dark:text-gray-100
                                               hover:bg-white/90 dark:hover:bg-gray-900/55 transition"
                                    @click="copyText(window.location.href)">
                                    Copy link
                                </button>

                                <a href="{{ $product->is_rental ? route('user.shop.rental') : route('user.shop.accessories') }}"
                                    class="flex-1 text-center px-4 py-3 rounded-2xl text-sm font-semibold
                                          bg-gray-900/5 dark:bg-white/10
                                          border border-gray-200/70 dark:border-gray-800/70
                                          text-gray-900 dark:text-gray-100
                                          hover:bg-gray-900/10 dark:hover:bg-white/15 transition">
                                    Browse more
                                </a>
                            </div>
                        </div>

                        {{-- Toast --}}
                        <div x-show="toast.show" x-transition.opacity class="fixed bottom-6 right-6 z-[120]">
                            <div class="rounded-2xl px-4 py-3 text-sm font-semibold
                                        bg-gray-900 text-white shadow-[0_20px_60px_-30px_rgba(0,0,0,0.6)]"
                                x-text="toast.message"></div>
                        </div>

                        {{-- Lightbox --}}
                        <div x-show="lightbox.open" x-transition.opacity
                            class="fixed inset-0 z-[200] bg-black/70 backdrop-blur-sm"
                            @keydown.escape.window="closeLightbox()" @click.self="closeLightbox()">
                            <div class="w-full h-full flex items-center justify-center p-4">
                                <div class="relative max-w-5xl w-full">
                                    <button type="button"
                                        class="absolute -top-12 right-0 px-4 py-2 rounded-full text-sm font-semibold
                                                   bg-white/15 text-white hover:bg-white/25 transition"
                                        @click="closeLightbox()">
                                        Close
                                    </button>

                                    <div class="rounded-3xl overflow-hidden border border-white/15 bg-black/40">
                                        <img :src="lightbox.src"
                                            class="w-full max-h-[80vh] object-contain bg-black" />
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Related (optional) --}}
                    @isset($related)
                        @if ($related->count())
                            <div
                                class="mt-6 rounded-3xl border border-gray-200/70 dark:border-gray-800/70
                                        bg-white/60 dark:bg-gray-900/40 backdrop-blur-xl p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Related</h3>
                                    <a class="text-sm font-semibold text-amber-500 hover:text-amber-400"
                                        href="{{ $product->is_rental ? route('user.shop.rental') : route('user.shop.accessories') }}">
                                        View all
                                    </a>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    @foreach ($related as $item)
                                        <a href="{{ route('user.product.show', $item->id) }}"
                                            class="group rounded-2xl overflow-hidden border border-gray-200/70 dark:border-gray-800/70
                                                  bg-white/60 dark:bg-gray-900/35 hover:shadow-lg transition">
                                            <div class="aspect-[4/3] bg-gray-100 dark:bg-gray-900">
                                                <img src="{{ $item->image }}"
                                                    class="w-full h-full object-cover group-hover:scale-[1.03] transition" />
                                            </div>
                                            <div class="p-3">
                                                <p
                                                    class="text-sm font-semibold text-gray-900 dark:text-gray-100 line-clamp-1">
                                                    {{ $item->name }}
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                    {{ number_format((float) $item->price, 0, ',', '.') }}₫
                                                </p>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endisset
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
