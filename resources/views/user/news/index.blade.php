<x-app-layout>
    <x-slot name="header">
        <div class="sr-only">
            <h1>Tin tức — Always Café</h1>
        </div>
    </x-slot>

    {{-- ======= Magical BG layers ======= --}}
    <section class="relative">
        {{-- Glow orbs --}}
        <div
            class="pointer-events-none absolute -top-40 right-0 w-[520px] h-[520px] rounded-full bg-amber-400/10 blur-3xl">
        </div>
        <div
            class="pointer-events-none absolute -bottom-20 left-0 w-[520px] h-[520px] rounded-full bg-purple-500/10 blur-3xl">
        </div>
        {{-- Starfield canvas (nếu đã có component nền thì có thể bỏ) --}}
        <canvas id="starfield" class="absolute inset-0 w-full h-full"></canvas>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- ======= Hero ======= --}}
            <div
                class="hp-card rounded-3xl backdrop-blur-2xl border border-white/10 bg-white/5 dark:bg-black/20 shadow-[0_0_30px_rgba(255,215,0,0.08)] overflow-hidden">
                <div class="grid md:grid-cols-2 gap-6 p-6 md:p-10">
                    <div class="space-y-3">
                        <p class="hp-caption text-amber-200/90 flex items-center gap-2">
                            <i data-lucide="sparkles" class="w-4 h-4 text-amber-300"></i>
                            <span data-vi="Always Café • Newsroom" data-en="Always Café • Newsroom"></span>
                        </p>
                        <h2 class="text-3xl md:text-4xl font-semibold text-amber-100 leading-tight">
                            <span data-vi="Bản Tin Phép Thuật — Sự kiện, ưu đãi và câu chuyện hậu trường"
                                data-en="Magical News — Events, Offers and Behind-the-Scenes Stories"></span>
                        </h2>
                        <p class="text-stone-300/85">
                            <span
                                data-vi="Cập nhật mới nhất từ thế giới Always Café: workshop, menu mùa vụ, ưu đãi theo nhà và các câu chuyện “magic” phía sau quầy bar."
                                data-en="Latest updates from the Always Café world: workshops, seasonal menus, special offers and behind-the-scenes stories."></span>
                        </p>

                        {{-- Quick filters (placeholder, có thể nâng cấp Livewire sau) --}}
                        <div class="flex flex-wrap items-center gap-2 pt-2">
                            @foreach (['All', 'Workshop', 'Menu', 'Ưu đãi', 'Behind-the-scenes'] as $chip)
                                <button
                                    class="hp-caption px-3 py-1 rounded-full border border-amber-400/20 bg-black/30 text-amber-200 hover:border-amber-400/40 transition">
                                    {{ $chip }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="relative rounded-2xl overflow-hidden">
                        <div
                            class="absolute inset-0 bg-gradient-to-tr from-amber-500/10 via-transparent to-purple-500/10">
                        </div>
                        <x-fallback-image src="/images/hero-hogwarts.jpg" alt="Always Café News" />
                    </div>
                </div>
            </div>

            {{-- ======= News Grid ======= --}}
            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($news as $item)
                    <article
                        class="group hp-card rounded-2xl overflow-hidden backdrop-blur-xl bg-white/5 dark:bg-black/30 border border-white/10 transition-all duration-500 hover:scale-[1.01] hover:shadow-[0_10px_40px_rgba(255,215,0,0.12)]">
                        {{-- Cover --}}
                        <div class="relative aspect-[16/10] overflow-hidden">
                            <x-fallback-image src="{{ $item->image ?? '/images/fallback-news.jpg' }}"
                                alt="{{ $item->title }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-[1.05]" />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent">
                            </div>

                            {{-- Category badge (1 icon chung) --}}
                            <div class="absolute top-3 left-3">
                                <span
                                    class="hp-caption rounded-full bg-black/60 backdrop-blur-sm text-amber-200 px-3 py-1 border border-amber-400/30 flex items-center gap-1">
                                    <i data-lucide="newspaper" class="w-4 h-4 text-amber-300"></i>
                                    {{ $item->category ?? 'News' }}
                                </span>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="p-5 flex flex-col h-full">
                            <div class="flex items-center justify-between text-xs text-stone-400/80">
                                <div class="flex items-center gap-1.5">
                                    <i data-lucide="calendar" class="w-4 h-4 text-amber-300"></i>
                                    <span>{{ \Carbon\Carbon::parse($item->created_at)->format('M d, Y') }}</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <i data-lucide="clock" class="w-4 h-4 text-amber-300"></i>
                                    <span>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</span>
                                </div>
                            </div>

                            <h3 class="mt-3 text-lg font-semibold text-amber-100 leading-snug line-clamp-2">
                                {{ $item->title }}
                            </h3>

                            <p class="mt-2 text-stone-300/85 text-sm leading-relaxed line-clamp-3">
                                {{ \App\Support\Markdown::excerpt($item->content, 160) }}
                            </p>

                            <div class="mt-4 flex items-center justify-between">
                                <a href="{{ route('user.news.show', $item->id) }}"
                                    class="inline-flex items-center gap-2 text-amber-300 font-medium hover:text-amber-200 transition">
                                    <span data-vi="Đọc thêm" data-en="Read more"></span>
                                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                </a>

                                {{-- Share minimal --}}
                                <div class="flex items-center gap-3 text-amber-200/80">
                                    <button class="hover:text-amber-100 transition" title="Copy link" x-data
                                        @click.prevent="navigator.clipboard.writeText('{{ route('user.news.show', $item->id) }}')">
                                        <i data-lucide="link" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </article>
                @empty
                    <div
                        class="sm:col-span-2 lg:col-span-3 hp-card rounded-2xl p-10 text-center border border-white/10 bg-white/5">
                        <i data-lucide="ghost" class="w-8 h-8 mx-auto text-amber-300"></i>
                        <p class="mt-3 text-amber-100 font-medium"><span data-vi="Chưa có bài viết nào."
                                data-en="No articles available."></span></p>
                        <p class="text-stone-400/80 text-sm"><span
                                data-vi="Hãy quay lại sau để khám phá thế giới phép thuật mới!"
                                data-en="Come back later to discover the magical world!"></span></p>
                    </div>
                @endforelse
            </div>

            {{-- ======= Pagination ======= --}}
            <div class="mt-8">
                {{ $news->onEachSide(1)->links() }}
            </div>
        </div>
    </section>

    {{-- ======= Subtle helper styles (tuỳ chọn) ======= --}}
    <style>
        .hp-card {
            will-change: transform, box-shadow, filter;
        }

        .hp-caption {
            font-size: 12px;
            letter-spacing: .02em;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-app-layout>
