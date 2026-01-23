<x-app-layout>
    <x-slot name="header">
        <div class="sr-only">
            <h1>{{ $news->title }} — Always Café</h1>
        </div>
    </x-slot>

    {{-- ======= Magical Background ======= --}}
    <section class="relative">
        {{-- Glowing aura --}}
        <div
            class="pointer-events-none absolute -top-40 right-0 w-[520px] h-[520px] rounded-full bg-amber-400/10 blur-3xl">
        </div>
        <div
            class="pointer-events-none absolute -bottom-20 left-0 w-[520px] h-[520px] rounded-full bg-purple-500/10 blur-3xl">
        </div>
        <canvas id="starfield" class="absolute inset-0 w-full h-full"></canvas>

        {{-- ======= Content ======= --}}
        <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- === Header Card === --}}
            <div
                class="hp-card rounded-3xl backdrop-blur-2xl border border-white/10 bg-white/5 dark:bg-black/20 shadow-[0_0_30px_rgba(255,215,0,0.08)] overflow-hidden">
                <div class="relative">
                    {{-- Cover Image --}}
                    <x-fallback-image src="{{ $news->image ?? '/images/fallback-news.jpg' }}" alt="{{ $news->title }}"
                        class="w-full h-[420px] object-cover" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>

                    {{-- Category Badge --}}
                    <div class="absolute top-4 left-4">
                        <span
                            class="hp-caption rounded-full bg-black/60 backdrop-blur-sm text-amber-200 px-3 py-1 border border-amber-400/30 flex items-center gap-1">
                            <i data-lucide="newspaper" class="w-4 h-4 text-amber-300"></i>
                            {{ $news->category ?? 'News' }}
                        </span>
                    </div>
                </div>

                {{-- === Article Body === --}}
                <div class="p-8 md:p-10">
                    {{-- Meta info --}}
                    <div class="flex flex-wrap items-center justify-between text-sm text-stone-400/80 mb-5">
                        <div class="flex items-center gap-2">
                            <i data-lucide="calendar" class="w-4 h-4 text-amber-300"></i>
                            {{ \Carbon\Carbon::parse($news->created_at)->format('M d, Y') }}
                        </div>
                        <div class="flex items-center gap-2">
                            <i data-lucide="clock" class="w-4 h-4 text-amber-300"></i>
                            {{ \Carbon\Carbon::parse($news->created_at)->diffForHumans() }}
                        </div>
                    </div>

                    {{-- Title --}}
                    <h1 class="text-3xl md:text-4xl font-semibold text-amber-100 mb-6 leading-snug">
                        {{ $news->title }}
                    </h1>

                    @php
                        $galleryUrls = $galleryUrls ?? [];
                        $md = $news->content ?? '';

                        $html = \App\Support\Markdown::toSafeHtml($md);

                        $html = preg_replace_callback(
                            '/\{\{img:(\d)(?:\|cap:(.*?))?\}\}/s',
                            function ($m) use ($galleryUrls) {
                                $n = (int) $m[1];
                                $url = $galleryUrls[$n - 1] ?? null;
                                $cap = isset($m[2]) ? trim($m[2]) : '';

                                if (!$url) {
                                    return '<div>(Image ' . $n . ' not selected yet)</div>';
                                }

                                $capHtml = $cap ? '<figcaption>' . e($cap) . '</figcaption>' : '';
                                return '<figure><img src="' .
                                    e($url) .
                                    '" alt="Gallery ' .
                                    $n .
                                    '" />' .
                                    $capHtml .
                                    '</figure>';
                            },
                            $html,
                        );
                    @endphp

                    <article class="prose prose-invert prose-amber max-w-none text-stone-200 leading-relaxed">
                        {!! $html !!}
                    </article>


                    {{-- Share section --}}
                    <div class="mt-10 flex items-center justify-between border-t border-amber-400/20 pt-6">
                        <a href="{{ route('user.news.index') }}"
                            class="inline-flex items-center gap-2 text-amber-300 hover:text-amber-200 font-medium transition">
                            <i data-lucide="arrow-left" class="w-4 h-4"></i>
                            <span data-vi="Quay lại bản tin" data-en="Back to News"></span>
                        </a>

                        <div class="flex items-center gap-4 text-amber-200/80">
                            {{-- Copy link --}}
                            <button class="hover:text-amber-100 transition" title="Sao chép liên kết" x-data
                                @click.prevent="navigator.clipboard.writeText('{{ url()->current() }}')">
                                <i data-lucide="link" class="w-5 h-5"></i>
                            </button>

                            {{-- Facebook --}}
                            <a class="hover:text-amber-100 transition" title="Chia sẻ Facebook" target="_blank"
                                rel="noopener noreferrer"
                                href="https://www.facebook.com/share/1FZ4f5fgk9/?mibextid=wwXIfr">
                                <i data-lucide="facebook" class="w-5 h-5"></i>
                            </a>

                            {{-- Instagram --}}
                            <a class="hover:text-amber-100 transition" title="Instagram" target="_blank"
                                rel="noopener noreferrer"
                                href="https://www.instagram.com/always.cafe/?igsh=Z3B0MWNpcjd1bXVq">
                                <i data-lucide="instagram" class="w-5 h-5"></i>
                            </a>

                            {{-- TikTok (dùng icon nốt nhạc giống footer) --}}
                            <a class="hover:text-amber-100 transition" title="TikTok" target="_blank"
                                rel="noopener noreferrer"
                                href="https://www.tiktok.com/@alwayscafe.vn?_t=ZS-90ZLtfxAEki&_r=1">
                                <i data-lucide="music-2" class="w-5 h-5"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- === Related Section (optional) === --}}
            <div class="py-10">
                <h3 class="text-xl font-semibold text-amber-100 mb-4 flex items-center gap-2">
                    <i data-lucide="sparkles" class="w-5 h-5 text-amber-300"></i>
                    <span data-vi="Bài viết liên quan" data-en="Related Articles"></span>
                </h3>
                <div class="grid gap-6 sm:grid-cols-2">
                    @foreach ($related as $relatedItem)
                        <a href="{{ route('user.news.show', $relatedItem->id) }}"
                            class="group hp-card rounded-2xl p-5 bg-white/5 dark:bg-black/20 border border-white/10 backdrop-blur-xl hover:scale-[1.02] transition-all">
                            <div class="flex items-center gap-4">
                                <div class="w-20 h-20 rounded-xl overflow-hidden flex-shrink-0">
                                    <x-fallback-image src="{{ $relatedItem->image ?? '/images/fallback-news.jpg' }}"
                                        alt="{{ $relatedItem->title }}"
                                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
                                </div>
                                <div>
                                    <h4 class="text-amber-100 font-semibold line-clamp-2">
                                        {{ $relatedItem->title }}
                                    </h4>
                                    <p class="text-sm text-stone-400/80 mt-1">
                                        {{ \Carbon\Carbon::parse($relatedItem->created_at)->format('M d, Y') }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ======= Helper Styles ======= --}}
    <style>
        .prose-amber a {
            color: #fbbf24;
            text-decoration: underline;
        }

        .prose-amber strong {
            color: #fde68a;
        }

        .prose-amber figure {
            margin: 1.5rem 0;
        }

        .prose-amber figure>img {
            width: 100%;
            border-radius: 1rem;
            /* bo góc */
            display: block;
        }

        .prose-amber figure>figcaption {
            margin-top: .5rem;
            text-align: center;
            /* căn giữa */
            font-style: italic;
            /* in nghiêng */
            font-size: 12px;
            /* chữ nhỏ */
            line-height: 1.25rem;
            color: rgba(231, 229, 228, .7);
            /* stone-ish */
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .hp-card {
            will-change: transform, box-shadow, filter;
        }
    </style>
</x-app-layout>
