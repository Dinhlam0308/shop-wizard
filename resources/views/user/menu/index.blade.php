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
                <span data-vi="Nơi hương vị cổ điển gặp gỡ phép màu hiện đại ✨" data-en="Where classic flavors meet modern magic ✨"></span>
            </p>
        </header>
    </x-slot>
    <section class="relative max-w-7xl mx-auto px-6 font-[Inter] select-none">

        <div class="flex flex-wrap justify-center gap-3 mb-10">
            <a href="{{ route('user.menu.index', ['category' => null]) }}"
                class="flex items-center gap-2 px-5 py-2.5 rounded-full 
           {{ request('category') === null
               ? 'bg-amber-400/20 border-amber-400 text-amber-300 shadow-[0_0_20px_rgba(255,215,0,0.3)]'
               : 'bg-gradient-to-r from-gray-900/70 to-gray-800/60 border border-amber-400/30 text-gray-100' }}
           text-sm font-medium backdrop-blur-lg transition-all duration-500 hover:scale-[1.05]">
                <i data-lucide="tags" class="w-4 h-4 text-amber-400"></i>
                <span data-vi="Tất cả" data-en="All"></span>
            </a>
            @foreach ($categories as $cat)
                <a href="{{ route('user.menu.index', ['category' => $cat]) }}"
                    class="flex items-center gap-2 px-5 py-2.5 rounded-full 
           {{ request('category') === $cat
               ? 'bg-amber-400/20 border-amber-400 text-amber-300 shadow-[0_0_20px_rgba(255,215,0,0.3)]'
               : 'bg-gradient-to-r from-gray-900/70 to-gray-800/60 border border-amber-400/30 text-gray-100' }}
           text-sm font-medium backdrop-blur-lg transition-all duration-500 hover:scale-[1.05]">
                    <i data-lucide="tags" class="w-4 h-4 text-amber-400"></i>
                    {{ $cat }}
                </a>
            @endforeach
        </div>

        {{-- Legend trạng thái --}}
        <div class="flex justify-center gap-6 text-sm text-gray-400 mb-8">
            <div class="flex items-center gap-1">
                <i data-lucide="check-circle" class="w-4 h-4 text-emerald-400"></i>
                <span data-vi="Đang phục vụ" data-en="Available"></span>
            </div>
            <div class="flex items-center gap-1">
                <i data-lucide="x-circle" class="w-4 h-4 text-rose-400"></i>
                <span data-vi="Tạm ngưng phục vụ" data-en="Unavailable"></span>
            </div>
        </div>

        {{-- Grid món ăn --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
            @forelse ($menu as $item)
                @php
                    $imageUrl = $item->image
                        ? (Str::startsWith($item->image, ['http://', 'https://'])
                            ? $item->image
                            : asset('storage/' . $item->image))
                        : '/images/default-drink.jpg';
                @endphp

                <article
                    class="group relative rounded-3xl overflow-hidden border border-white/10 
                    bg-gradient-to-b from-white via-white/80 to-white/40 dark:from-[#111]/70 dark:via-[#0c0c0c]/60 dark:to-[#090909]/50 
                    backdrop-blur-2xl shadow-[0_8px_40px_rgba(255,215,0,0.05)]
                    hover:shadow-[0_15px_60px_rgba(255,215,0,0.25)] 
                    hover:ring-2 hover:ring-amber-400/40 transition-all duration-700 ease-[cubic-bezier(0.25,0.46,0.45,0.94)]">

                    {{-- Hình ảnh --}}
                    <div class="relative aspect-[4/3] overflow-hidden">
                        <img src="{{ $imageUrl }}" alt="{{ $item->name }}"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/10 to-transparent"></div>
                        <i data-lucide="coffee" class="absolute top-3 left-3 w-5 h-5 text-amber-300"></i>
                    </div>

                    {{-- Nội dung --}}
                    <div class="p-6 flex flex-col justify-between min-h-[180px]">
                        <div>
                            <h3
                                class="text-lg font-[Playfair_Display] font-semibold 
                                text-gray-900 dark:text-gray-100 tracking-tight mb-1
                                group-hover:text-amber-500 transition-colors">
                                {{ $item->name }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed line-clamp-2">
                                {{ $item->description }}
                            </p>
                        </div>

                        {{-- Giá và trạng thái --}}
                        <div class="mt-4 flex items-center justify-between">
                            <span class="flex items-center gap-1 text-amber-400 font-medium">
                                <i data-lucide="coins" class="w-4 h-4"></i>
                                {{ number_format($item->price, 2) }}₫
                            </span>
                            @if ($item->available)
                                <i data-lucide="check-circle" class="w-5 h-5 text-emerald-400"></i>
                            @else
                                <i data-lucide="x-circle" class="w-5 h-5 text-rose-400"></i>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full text-center py-20">
                    <p class="text-lg text-gray-500 dark:text-gray-400 font-[Inter]">
                        <span data-vi="Không tìm thấy món nào trong thực đơn!" data-en="No items found in the menu!"></span>
                    </p>
                </div>
            @endforelse
        </div>

        {{-- Phân trang --}}
        <div>
            {{ $menu->links('components.pagination_magical') }}
        </div>
    </section>

    {{-- Lucide icons --}}
    <script>
        lucide.createIcons();
    </script>
</x-app-layout>
