<x-app-layout>

    {{-- ===== Page container ===== --}}
    <div>
        {{-- ===== HERO SECTION ===== --}}
        <section class="relative overflow-hidden min-h-[calc(100vh-4rem)] flex items-center">

            <h1 class="sr-only">Always Café — Nơi Phép Thuật Gặp Gỡ Hiện Đại</h1>

            {{-- BACKGROUND SLIDESHOW --}}
            <div class="absolute inset-0 -z-10">
                <div class="hp-bg-slide hp-bg-1"></div>
                <div class="hp-bg-slide hp-bg-2"></div>
                <div class="hp-bg-slide hp-bg-3"></div>

                <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/55 to-black/80"></div>
                <div class="absolute inset-0 hp-vignette pointer-events-none"></div>
            </div>

            {{-- CONTENT --}}
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    {{-- Left: Enhanced title + actions --}}
                    <div class="space-y-8">

                        {{-- Main headline --}}
                        <div class="space-y-4">
                            <h2 class="hp-title hp-display font-bold tracking-tight text-amber-50 mt-20">
                                <span data-vi="Chào mừng các Muggle đến với" data-en="Welcome to"></span>
                                <span
                                    class="block text-transparent bg-clip-text bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500">
                                    <span data-vi="Always Café" data-en="Always Café"></span>
                                </span>
                            </h2>
                        </div>

                        {{-- Description --}}
                        <div class="space-y-4">
                            <p class="hp-body-large text-stone-200/90 leading-relaxed">
                                <span class="text-amber-200 font-medium"><span data-vi="Góc phép thuật giữa lòng Hà Nội"
                                        data-en="Magic corner in the heart of Hanoi"></span>.</span>
                            </p>
                        </div>

                        {{-- CTA buttons --}}
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('user.menu.index') }}"
                                class="hp-btn-primary inline-flex items-center gap-3 rounded-2xl px-6 py-4 text-base font-semibold hp-hover hp-glow">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path d="M3 6h18v2H3zM3 11h18v2H3zM3 16h18v2H3z" />
                                </svg>
                                <span data-vi="Khám Phá Menu Phép Thuật" data-en="Explore the Magic Menu"></span>
                            </a>
                            <a href="{{ route('user.booking') }}"
                                class="hp-btn-secondary inline-flex items-center gap-3 rounded-2xl px-6 py-4 text-base font-semibold hp-hover">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 2l3 7 7 3-7 3-3 7-3-7-7-3 7-3z" />
                                </svg>
                                <span data-vi="Đặt Chỗ Ngay" data-en="Book Your Spot Now"></span>
                            </a>
                        </div>
                    </div>

                    {{-- Right: Enhanced hero card --}}
                    <div class="relative">
                        {{-- Enhanced floating particles around hero card --}}
                        <div class="absolute -top-6 -right-6 w-3 h-3 bg-amber-400/70 rounded-full hp-particle"
                            style="animation-delay: 0s;"></div>
                        <div class="absolute -top-2 -right-12 w-1.5 h-1.5 bg-yellow-300/60 rounded-full hp-particle-slow"
                            style="animation-delay: 2s;"></div>
                        <div class="absolute top-1/4 -left-4 w-2 h-2 bg-amber-500/50 rounded-full hp-particle-reverse"
                            style="animation-delay: 4s;"></div>
                        <div class="absolute top-1/3 -right-8 w-2.5 h-2.5 bg-purple-400/40 rounded-full hp-particle-spiral"
                            style="animation-delay: 1s;"></div>
                        <div class="absolute top-1/2 -left-6 w-1 h-1 bg-amber-300/80 rounded-full hp-particle"
                            style="animation-delay: 6s;"></div>
                        <div class="absolute bottom-1/3 -right-3 w-1.5 h-1.5 bg-yellow-400/60 rounded-full hp-particle-slow"
                            style="animation-delay: 3s;"></div>
                        <div class="absolute bottom-1/4 right-12 w-2 h-2 bg-amber-500/50 rounded-full hp-particle-reverse"
                            style="animation-delay: 5s;"></div>
                        <div class="absolute -bottom-4 -left-2 w-2.5 h-2.5 bg-purple-300/40 rounded-full hp-particle-spiral"
                            style="animation-delay: 7s;"></div>
                        <div class="absolute -bottom-6 -right-6 w-3 h-3 bg-amber-400/70 rounded-full hp-particle"
                            style="animation-delay: 4s;"></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mt-20 md:mt-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h3 class="hp-title hp-headline text-amber-200 mb-3">
                        <span data-vi="Tủ Đồ Phép Thuật" data-en="Magic Wardrobe"></span>
                    </h3>
                    <div class="w-24 h-px hp-divider mx-auto"></div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                    @php
                        $cats = [
                            [
                                'name' => ['vi' => 'Trang Phục', 'en' => 'Costumes'],
                                'route' => route('user.shop.rental'),
                                'bg' => asset('images/categories/costume.jpg'),
                            ],
                            [
                                'name' => ['vi' => 'Phụ Kiện', 'en' => 'Accessories'],
                                'route' => route('user.shop.accessories'),
                                'bg' => asset('images/categories/accessories.jpg'),
                            ],
                            [
                                'name' => ['vi' => 'Đũa Phép', 'en' => 'Wands'],
                                'route' => route('user.shop.accessories'),
                                'bg' => asset('images/categories/wand.jpg'),
                            ],
                            [
                                'name' => ['vi' => 'Set Quà', 'en' => 'Gift Sets'],
                                'route' => route('user.shop.accessories'),
                                'bg' => asset('images/categories/gift.jpg'),
                            ],
                        ];
                    @endphp
                    @foreach ($cats as $c)
                        <a href="{{ $c['route'] }}"
                            class="group relative rounded-2xl overflow-hidden
          aspect-[4/5] md:aspect-[3/4]
          flex items-end justify-center
          transition-all duration-500 hover:scale-[1.02]"
                            style="background-image: url('{{ $c['bg'] }}');
          background-size: cover;
          background-position: center;">

                            {{-- Dark overlay --}}
                            <div class="absolute inset-0 bg-black/45 group-hover:bg-black/30 transition"></div>

                            {{-- Magical gradient --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent">
                            </div>

                            {{-- Content --}}
                            <div class="relative z-10 w-full text-center pb-6 px-4">
                                <h4 class="text-amber-100 font-semibold tracking-wide text-sm md:text-base">
                                    <span data-vi="{{ $c['name']['vi'] }}" data-en="{{ $c['name']['en'] }}"></span>
                                </h4>

                                <div
                                    class="mx-auto mt-3 w-8 h-px
                   bg-gradient-to-r from-transparent via-amber-400/60 to-transparent
                   group-hover:via-amber-300 transition">
                                </div>

                                <p class="mt-2 text-xs text-stone-300/70 tracking-wide">
                                    <span data-vi="Khám phá ngay" data-en="Explore Now"></span>
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="mt-14 md:mt-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <a href="{{ route('user.shop.accessories') }}"
                    class="group relative block overflow-hidden rounded-3xl hp-card hp-hover">

                    {{-- Background image --}}
                    <div class="absolute inset-0">
                        <div class="hp-promo-bg"
                            style="background-image:url('{{ asset('images/categories/Accessories_bg.jpg') }}')"></div>

                        {{-- Overlay --}}
                        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-black/20"></div>
                        <div class="absolute inset-0 hp-vignette pointer-events-none"></div>
                    </div>

                    {{-- Content --}}
                    <div class="relative z-10 px-6 py-10 md:px-10 md:py-14">
                        <div class="max-w-2xl space-y-4">
                            <p class="inline-flex items-center gap-2 text-xs md:text-sm text-amber-200/90">
                                <span class="h-2 w-2 rounded-full bg-amber-400 animate-pulse"></span>
                                <span data-vi="Ưu đãi & Trải nghiệm mới" data-en="Special Offers & Experiences"></span>
                            </p>

                            <h3 class="hp-title text-2xl md:text-4xl font-bold text-amber-50 leading-tight">
                                <span data-vi="Tủ Đồ Phép Thuật Đang Chờ Bạn Khám Phá"
                                    data-en="Your Magical Wardrobe Awaits"></span>
                            </h3>

                            <p class="hp-body-large text-stone-200/90 leading-relaxed">
                                <span data-vi="Trải nghiệm thế giới phép thuật với"
                                    data-en="Experience the magical world with"></span> <b
                                    class="text-amber-200">boardgame</b>,
                                <b class="text-amber-200"><span data-vi="áo choàng" data-en="hoodie"></span></b>
                                <span data-vi="tàng hình" data-en="of Invisibility"></span>, <b
                                    class="text-amber-200"><span data-vi="đũa phép" data-en="wand"></span></b>,
                                <b class="text-amber-200"><span data-vi="mũ phân loại" data-en="hat"></span></b>
                                <span data-vi="và nhiều hơn thế nữa!" data-en="and more!"></span>
                            </p>

                            <div class="pt-2">
                                <span
                                    class="inline-flex items-center gap-3 rounded-2xl px-6 py-4
                                   text-base font-semibold
                                   hp-btn-primary hp-glow
                                   transition-all duration-500
                                   group-hover:translate-y-[-1px]">
                                    <span data-vi="Khám phá ngay" data-en="Explore Now"></span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                        fill="currentColor">
                                        <path d="M13.172 12l-4.95-4.95 1.414-1.414L16 12l-6.364 6.364-1.414-1.414z" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Soft highlight --}}
                    <div
                        class="pointer-events-none absolute -top-24 -right-24 h-64 w-64 rounded-full
                        bg-amber-400/15 blur-3xl
                        opacity-0 group-hover:opacity-100 transition duration-700">
                    </div>
                </a>
            </div>
        </section>

        <section class="mt-14 md:mt-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                {{-- Title --}}
                <div class="text-center mb-10 md:mb-12">
                    <h3 class="hp-title hp-headline text-amber-200 mb-3"><span data-vi="Trải Nghiệm Phép Thuật"
                            data-en="Magical Experiences"></span></h3>
                    <div class="w-24 h-px hp-divider mx-auto"></div>
                </div>

                {{-- GRID: left big + right 2 stacked --}}
                <div class="grid md:grid-cols-2 gap-4 md:gap-6">
                    {{-- LEFT BIG: POTION CLASS --}}
                    <a href="{{ route('user.booking') }}"
                        class="group relative overflow-hidden rounded-3xl hp-card hp-hover min-h-[360px] md:min-h-[520px] flex items-end">
                        {{-- Background --}}
                        <div class="absolute inset-0">
                            <div class="hp-exp-bg"
                                style="background-image:url('{{ asset('images/experience/potionclass.jpg') }}')"></div>

                            {{-- overlays --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/35 to-black/20">
                            </div>
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-black/40 via-transparent to-transparent">
                            </div>
                            <div class="absolute inset-0 hp-vignette pointer-events-none"></div>
                        </div>

                        {{-- Content (bottom-left) --}}
                        <div class="relative z-10 w-full p-6 md:p-8">

                            <h4 class="mt-3 text-2xl md:text-3xl font-bold text-amber-50 tracking-tight">
                                <span data-vi="Lớp học độc dược" data-en="Potion Class"></span>
                            </h4>

                            <p class="mt-2 text-sm md:text-base text-stone-200/90 leading-relaxed max-w-xl">
                                <span
                                    data-vi="Tự tay pha chế những lọ thuốc phép thuật trong không gian huyền bí, đầy ánh sáng và hương vị."
                                    data-en="Brew magical potions yourself in a mysterious, light-filled space with rich flavors."></span>
                            </p>

                            {{-- CTA inside blur chip --}}
                            <div class="mt-5">
                                <span
                                    class="hp-cta
inline-flex items-center gap-3
rounded-2xl px-5 py-3
text-sm md:text-base font-semibold
text-amber-100
backdrop-blur-xl
border border-white/15
shadow-[0_18px_40px_rgba(0,0,0,0.35)]
transition-all duration-500 ease-[cubic-bezier(.16,1,.3,1)]
group-hover:-translate-y-[2px]
group-hover:shadow-[0_30px_70px_rgba(0,0,0,0.55)]">
                                    <span data-vi="Khám phá ngay" data-en="Explore Now"></span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                        fill="currentColor">
                                        <path d="M13.172 12l-4.95-4.95 1.414-1.414L16 12l-6.364 6.364-1.414-1.414z" />
                                    </svg>
                                </span>
                            </div>
                        </div>

                        {{-- Soft highlight --}}
                        <div
                            class="pointer-events-none absolute -top-24 -right-24 h-64 w-64 rounded-full bg-amber-400/15 blur-3xl
                            opacity-0 group-hover:opacity-100 transition duration-700">
                        </div>
                    </a>

                    {{-- RIGHT STACK: TAROT (top) + WORKSHOP (bottom) --}}
                    <div class="grid gap-4 md:gap-6">
                        {{-- TOP: TAROT --}}
                        <a href="{{ route('user.booking.tarot') }}"
                            class="group relative overflow-hidden rounded-3xl hp-card hp-hover min-h-[240px] md:min-h-[248px] flex items-end">
                            <div class="absolute inset-0">
                                <div class="hp-exp-bg"
                                    style="background-image:url('{{ asset('images/experience/tarot.jpg') }}')"></div>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/20">
                                </div>
                                <div class="absolute inset-0 hp-vignette pointer-events-none"></div>
                            </div>

                            <div class="relative z-10 w-full p-6 md:p-7">

                                <h4 class="mt-3 text-xl md:text-2xl font-bold text-amber-50 tracking-tight">
                                    Tarot
                                </h4>

                                <p class="mt-2 text-sm text-stone-200/90 leading-relaxed">
                                    <span
                                        data-vi="Lắng nghe thông điệp từ vũ trụ qua từng lá bài, mở ra góc nhìn mới cho bạn."
                                        data-en="Listen to messages from the universe through each card, revealing a new perspective for you."></span>
                                </p>

                                <div class="mt-4">
                                    <span
                                        class="hp-cta
inline-flex items-center gap-3
rounded-2xl px-5 py-3
text-sm md:text-base font-semibold
text-amber-100
backdrop-blur-xl
border border-white/15
shadow-[0_18px_40px_rgba(0,0,0,0.35)]
transition-all duration-500 ease-[cubic-bezier(.16,1,.3,1)]
group-hover:-translate-y-[2px]
group-hover:shadow-[0_30px_70px_rgba(0,0,0,0.55)]">
                                        <span data-vi="Khám phá ngay" data-en="Explore Now"></span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                            fill="currentColor">
                                            <path
                                                d="M13.172 12l-4.95-4.95 1.414-1.414L16 12l-6.364 6.364-1.414-1.414z" />
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <div
                                class="pointer-events-none absolute -top-24 -right-24 h-56 w-56 rounded-full bg-purple-300/12 blur-3xl
                                opacity-0 group-hover:opacity-100 transition duration-700">
                            </div>
                        </a>

                        {{-- BOTTOM: WORKSHOP --}}
                        <a href="{{ route('user.workshops.index') }}"
                            class="group relative overflow-hidden rounded-3xl hp-card hp-hover min-h-[240px] md:min-h-[248px] flex items-end">
                            <div class="absolute inset-0">
                                <div class="hp-exp-bg"
                                    style="background-image:url('{{ asset('images/experience/workshop.jpg') }}')">
                                </div>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/20">
                                </div>
                                <div class="absolute inset-0 hp-vignette pointer-events-none"></div>
                            </div>

                            <div class="relative z-10 w-full p-6 md:p-7">

                                <h4 class="mt-3 text-xl md:text-2xl font-bold text-amber-50 tracking-tight">
                                    Workshop
                                </h4>

                                <p class="mt-2 text-sm text-stone-200/90 leading-relaxed">
                                    <span
                                        data-vi="Khám phá những buổi workshop phép thuật theo chủ đề — vui, sáng tạo và đậm chất Always."
                                        data-en="Explore magical workshops themed — fun, creative, and full of 'Always' spirit."></span>
                                </p>

                                <div class="mt-4">
                                    <span
                                        class="hp-cta
inline-flex items-center gap-3
rounded-2xl px-5 py-3
text-sm md:text-base font-semibold
text-amber-100
backdrop-blur-xl
border border-white/15
shadow-[0_18px_40px_rgba(0,0,0,0.35)]
transition-all duration-500 ease-[cubic-bezier(.16,1,.3,1)]
group-hover:-translate-y-[2px]
group-hover:shadow-[0_30px_70px_rgba(0,0,0,0.55)]">
                                        <span data-vi="Khám phá ngay" data-en="Explore Now"></span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                            fill="currentColor">
                                            <path
                                                d="M13.172 12l-4.95-4.95 1.414-1.414L16 12l-6.364 6.364-1.414-1.414z" />
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <div
                                class="pointer-events-none absolute -top-24 -right-24 h-56 w-56 rounded-full bg-amber-400/12 blur-3xl
                                opacity-0 group-hover:opacity-100 transition duration-700">
                            </div>
                        </a>
                    </div>
                </div>

            </div>
        </section>

        <section class="mt-14 md:mt-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <a href="{{ route('user.shop.rental') }}"
                    class="group relative block overflow-hidden rounded-3xl hp-card hp-hover min-h-[360px] md:min-h-[460px]">

                    {{-- Background image --}}
                    <div class="absolute inset-0">
                        <div class="hp-exp-bg"
                            style="background-image:url('{{ asset('images/experience/accessories-hero.jpg') }}')">
                        </div>

                        {{-- Overlays --}}
                        <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/55 to-black/20"></div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
                        <div class="absolute inset-0 hp-vignette pointer-events-none"></div>
                    </div>

                    {{-- Content: LEFT SIDE --}}
                    <div class="relative z-10 h-full flex items-center">
                        <div class="max-w-xl p-6 md:p-10 space-y-4">

                            {{-- Badge --}}
                            <div
                                class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-medium
                               bg-white/10 border border-white/15 text-amber-100 backdrop-blur-md">
                                <span class="h-2 w-2 rounded-full bg-amber-400 animate-pulse"></span>
                                <span data-vi="Hóa thân phù thủy & pháp sư"
                                    data-en="Become a wizard & sorcerer"></span>
                            </div>

                            {{-- Title --}}
                            <h3 class="hp-title text-2xl md:text-4xl font-bold text-amber-50 leading-tight">
                                <span data-vi="Hóa thân phù thủy & pháp sư"
                                    data-en="Become a wizard & sorcerer"></span><br class="hidden sm:block">
                                <span data-vi="cùng" data-en="with"></span> <span
                                    class="text-transparent bg-clip-text bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500">
                                    Always
                                </span>
                            </h3>

                            {{-- Description --}}
                            <p class="hp-body-large text-stone-200/90 leading-relaxed">
                                <span data-vi="Always mang đến những bộ" data-en="Always brings you"></span>
                                <b class="text-amber-200">
                                    <span data-vi=" outfit “chuẩn phù thủy”"
                                        data-en=" authentic wizard outfits"></span>
                                </b>,
                                <span data-vi=" giúp bạn trải nghiệm cảm giác hóa thân học sinh Hogwarts trọn vẹn."
                                    data-en=" allowing you to fully immerse yourself in the experience of becoming a Hogwarts student."></span>
                            </p>

                            {{-- CTA --}}
                            <div class="pt-2">
                                <span
                                    class="hp-cta inline-flex items-center gap-3 rounded-2xl px-6 py-4
                                   text-base font-semibold text-amber-100
                                   backdrop-blur-xl border border-white/15
                                   shadow-[0_18px_40px_rgba(0,0,0,0.35)]
                                   transition-all duration-500
                                   group-hover:-translate-y-[2px]
                                   group-hover:shadow-[0_30px_70px_rgba(0,0,0,0.55)]">
                                    <span data-vi="Khám phá ngay" data-en="Explore Now"></span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                        fill="currentColor">
                                        <path d="M13.172 12l-4.95-4.95 1.414-1.414L16 12l-6.364 6.364-1.414-1.414z" />
                                    </svg>
                                </span>
                            </div>

                        </div>
                    </div>

                    {{-- Soft glow --}}
                    <div
                        class="pointer-events-none absolute -top-32 -left-32 h-80 w-80 rounded-full
                       bg-amber-400/15 blur-3xl
                       opacity-0 group-hover:opacity-100 transition duration-700">
                    </div>
                </a>

            </div>
        </section>

        <style>
            /* Experience cards background zoom */
            .hp-exp-bg {
                position: absolute;
                inset: 0;
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                transform: scale(1.04);
                transition: transform 900ms ease;
                filter: saturate(1.05) contrast(1.05);
                will-change: transform;
            }

            a.group:hover .hp-exp-bg {
                transform: scale(1.09);
            }
        </style>

        <livewire:featured-menu />

        <livewire:workshop-list />

        <livewire:shop.rental-accessories />

        <livewire:shop.testimonials />
    </div>

    <style>
        /* Ảnh nền: chung */
        .hp-bg-slide {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;

            /* mượt */
            transform: scale(1.06);
            /* nhẹ zoom để cinematic */
            filter: saturate(1.05) contrast(1.05);
            opacity: 0;

            /* fade mượt */
            animation: hpFade 18s infinite ease-in-out;
            will-change: opacity, transform;
        }

        .hp-bg-1 {
            background-image: url('/images/bg1.jpg');
            animation-delay: 0s;
        }

        .hp-bg-2 {
            background-image: url('/images/bg2.jpg');
            animation-delay: 6s;
        }

        .hp-bg-3 {
            background-image: url('/images/bg3.jpg');
            animation-delay: 12s;
        }

        @keyframes hpFade {
            0% {
                opacity: 0;
                transform: scale(1.06);
            }

            8% {
                opacity: 1;
                transform: scale(1.03);
            }

            /* fade in */
            33% {
                opacity: 1;
                transform: scale(1.00);
            }

            /* giữ */
            41% {
                opacity: 0;
                transform: scale(1.02);
            }

            /* fade out */
            100% {
                opacity: 0;
                transform: scale(1.06);
            }
        }

        .hp-vignette {
            background:
                radial-gradient(60% 60% at 50% 35%, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.55) 100%),
                radial-gradient(120% 80% at 50% 20%, rgba(255, 200, 60, 0.06) 0%, rgba(0, 0, 0, 0) 60%);
        }

        @media (prefers-reduced-motion: reduce) {
            .hp-bg-slide {
                animation: none;
                opacity: 1;
            }

            .hp-bg-2,
            .hp-bg-3 {
                display: none;
            }
        }

        .hp-promo-bg {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            transform: scale(1.04);
            transition: transform 900ms ease;
            filter: saturate(1.05) contrast(1.05);
            will-change: transform;
        }

        a.group:hover .hp-promo-bg {
            transform: scale(1.08);
        }

        /* ===== Apple-style CTA ===== */
        .hp-cta {
            position: relative;
            background: linear-gradient(180deg,
                    rgba(255, 255, 255, 0.12),
                    rgba(255, 255, 255, 0.04));
            overflow: hidden;
        }

        /* Light sweep */
        .hp-cta::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg,
                    transparent 30%,
                    rgba(255, 255, 255, 0.35) 50%,
                    transparent 70%);
            transform: translateX(-120%);
            transition: transform 700ms cubic-bezier(.16, 1, .3, 1);
        }

        /* Hover glow edge */
        .hp-cta::after {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: inherit;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.15);
            opacity: 0;
            transition: opacity 400ms ease;
        }

        /* Hover states */
        .group:hover .hp-cta::before {
            transform: translateX(120%);
        }

        .group:hover .hp-cta::after {
            opacity: 1;
        }

        /* Active (click) */
        .hp-cta:active {
            transform: translateY(0);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.45);
        }
    </style>
</x-app-layout>
