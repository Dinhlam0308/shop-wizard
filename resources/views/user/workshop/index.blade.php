<x-app-layout>
    {{-- === Header ẩn cho SEO === --}}
    <x-slot name="header">
        <div class="sr-only">
            <h1>Workshop — Khám phá và trải nghiệm</h1>
        </div>
        {{-- Tiêu đề --}}
        <header class="text-center mb-12 space-y-3">
            <h2
                class="flex justify-center items-center gap-3 text-4xl md:text-5xl 
                font-[Playfair_Display] font-semibold tracking-tight 
                text-transparent bg-clip-text bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500">
                <i data-lucide="sparkles" class="w-8 h-8 text-amber-400 animate-pulse"></i>
                <span data-vi="Workshop kỳ diệu" data-en="Magical Workshop"></span>
                <i data-lucide="wand-2" class="w-8 h-8 text-yellow-300 animate-pulse"></i>
            </h2>
            <p class="mt-4 text-gray-300 max-w-2xl mx-auto text-lg leading-relaxed">
                <span data-vi="Không gian nơi cảm hứng gặp gỡ phép màu."
                    data-en="A space where inspiration meets magic."></span>
            </p>
        </header>
    </x-slot>

    {{-- === Main Section === --}}
    <section class="relative max-w-7xl mx-auto px-6 py-4 font-[Inter]">
        {{-- Danh sách Workshop --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
            @forelse ($workshops as $workshop)
                @php
                    $image = $workshop->image
                        ? (Str::startsWith($workshop->image, ['http://', 'https://'])
                            ? $workshop->image
                            : asset('storage/' . $workshop->image))
                        : 'https://picsum.photos/600/400?random=' . rand(1, 1000);
                @endphp

                <article
                    class="group relative rounded-3xl overflow-hidden border border-white/10
                            bg-white/5 backdrop-blur-2xl
                            shadow-[0_6px_30px_rgba(0,0,0,0.15)]
                            hover:shadow-[0_10px_50px_rgba(212,175,55,0.25)]
                            hover:border-amber-400/30 hover:-translate-y-1
                            transition-all duration-700 ease-[cubic-bezier(0.23,1,0.32,1)]">

                    <a href="{{ route('user.workshop.show', $workshop->id) }}" class="absolute inset-0 z-10"
                        aria-label="View workshop details"></a>
                    {{-- Hình ảnh --}}
                    <div class="relative aspect-[4/3] overflow-hidden">
                        <img src="{{ $image }}" alt="{{ $workshop->title }}"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-700">
                        </div>

                        {{-- Tag nổi bật --}}
                        <span
                            class="absolute top-4 left-4 px-3 py-1.5 text-xs font-medium rounded-full
                                   bg-gray-800/80 text-amber-300 border border-amber-400/30
                                   backdrop-blur-md">
                            <i data-lucide="calendar" class="w-3.5 h-3.5 inline-block mr-1"></i>
                            {{ \Carbon\Carbon::parse($workshop->date)->format('d/m/Y') }}
                        </span>
                    </div>

                    {{-- Nội dung --}}
                    <div class="p-6 flex flex-col justify-between h-[250px]">
                        <div>
                            <h3
                                class="text-xl font-semibold text-gray-100 mb-2 line-clamp-2 group-hover:text-amber-300 transition-colors">
                                {{ $workshop->title }}
                            </h3>
                            <p class="text-gray-400 text-sm line-clamp-2">
                                {{ $workshop->description }}
                            </p>
                        </div>

                        <div class="mt-4">
                            <div class="flex items-center justify-between text-gray-300 text-sm mb-2">
                                <span class="flex items-center gap-1">
                                    <i data-lucide="clock" class="w-4 h-4 text-amber-400"></i>
                                    {{ $workshop->time }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <i data-lucide="map-pin" class="w-4 h-4 text-rose-400"></i>
                                    {{ $workshop->location }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-xs text-gray-400">
                                        <span data-vi="Giá vé" data-en="Price"></span>
                                    </div>
                                    <div
                                        class="text-2xl font-bold bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">
                                        {{ number_format($workshop->price, 0, ',', '.') }}₫
                                    </div>
                                </div>
                                <a href="{{ route('user.workshop_registrations.create', $workshop->id) }}"
                                    class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-900
                                           bg-gradient-to-r from-amber-300 via-amber-400 to-yellow-500
                                           shadow-[0_4px_20px_rgba(212,175,55,0.25)]
                                           hover:shadow-[0_6px_30px_rgba(212,175,55,0.35)]
                                           hover:scale-[1.03]
                                           transition-all duration-300 ease-out">
                                    <i data-lucide="ticket" class="w-4 h-4 inline-block mr-1"></i>
                                    <span data-vi="Đăng ký" data-en="Register"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full text-center text-gray-400">
                    <span data-vi="Hiện chưa có workshop nào sắp diễn ra ✨"
                        data-en="No upcoming workshops available ✨"></span>
                </div>
            @endforelse
        </div>

        {{-- Phân trang --}}
        <div>
            {{ $workshops->links('components.pagination_magical') }}
        </div>
    </section>

    {{-- Hiệu ứng ánh sáng bay quanh --}}
    <div class="pointer-events-none fixed inset-0 overflow-hidden">
        <div class="absolute -top-10 -left-10 w-4 h-4 bg-amber-400/30 rounded-full animate-pulse"></div>
        <div
            class="absolute top-1/3 right-10 w-3 h-3 bg-yellow-200/20 rounded-full animate-[fade-in_3s_infinite_alternate]">
        </div>
        <div
            class="absolute bottom-16 left-1/2 w-2 h-2 bg-amber-300/30 rounded-full animate-[float_6s_ease-in-out_infinite]">
        </div>
    </div>

    {{-- Script Lucide --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => lucide.createIcons());
    </script>
</x-app-layout>
