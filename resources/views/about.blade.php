{{-- resources/views/pages/about.blade.php --}}
<x-app-layout>
    @push('styles')
        <style>
            :root {
                --ease-apple: cubic-bezier(.25, .46, .45, .94);
            }

            .hp-gradient-text {
                background: linear-gradient(135deg, #d4af37 0%, #f8e45f 50%, #ffd700 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .hp-glass {
                backdrop-filter: blur(18px);
                background: rgba(255, 255, 255, .06);
                border: 1px solid rgba(255, 255, 255, .14);
            }

            .hp-hero-bg {
                background:
                    radial-gradient(60rem 60rem at 10% 20%, rgba(212, 175, 55, .12), transparent 60%),
                    radial-gradient(40rem 40rem at 90% 30%, rgba(216, 180, 254, .12), transparent 60%),
                    radial-gradient(48rem 48rem at 50% 80%, rgba(255, 105, 180, .10), transparent 60%),
                    linear-gradient(180deg, #0a0a0a 0%, #151515 100%);
            }

            .hp-float {
                animation: hp-float 7s ease-in-out infinite;
            }

            @keyframes hp-float {

                0%,
                100% {
                    transform: translateY(0)
                }

                50% {
                    transform: translateY(-14px)
                }
            }

            .hp-shadow-soft {
                box-shadow: 0 10px 40px rgba(0, 0, 0, .22);
            }

            .hp-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 16px 50px rgba(212, 175, 55, .20);
            }

            .hp-timeline-line:before {
                content: "";
                position: absolute;
                inset: 0 50% 0 auto;
                width: 2px;
                background: linear-gradient(180deg, rgba(212, 175, 55, .0), rgba(212, 175, 55, .6), rgba(212, 175, 55, .0));
                transform: translateX(-1px);
            }

            /* Better focus */
            .focus-ring:focus-visible {
                outline: 2px solid #fbbf24;
                outline-offset: 3px;
                border-radius: .75rem;
            }
        </style>
    @endpush

    {{-- ===== HERO ===== --}}
    <section class="relative hp-hero-bg overflow-hidden">
        <div class="absolute -top-24 -left-24 w-[28rem] h-[28rem] bg-amber-400/10 blur-3xl rounded-full hp-float"></div>
        <div class="absolute -bottom-24 -right-24 w-[34rem] h-[34rem] bg-purple-500/10 blur-3xl rounded-full hp-float"
            style="animation-delay:1.8s"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 py-28 lg:py-36">
            <div class="grid lg:grid-cols-2 gap-10 items-center">
                <div>
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-white/15 text-amber-300 bg-white/5 hp-glass">
                        <i data-lucide="sparkles" class="w-4 h-4"></i>
                        <span class="text-xs tracking-wide">About Always Café</span>
                    </div>
                    <h1 class="mt-5 font-['Playfair_Display'] text-5xl lg:text-6xl font-bold leading-tight">
                        <span class="hp-gradient-text">
                            <span data-vi="Nơi ma thuật" data-en="Where magic"></span>
                        </span>
                        <span data-vi=" gặp gỡ " data-en=" meets "></span>
                        <span class="text-white">
                            <span data-vi="Cà Phê" data-en="Coffee"></span>
                        </span>
                    </h1>
                    <p class="mt-5 text-lg text-gray-300 max-w-xl">
                        <span
                            data-vi="Tại Always Café, chúng tôi tin rằng mỗi tách cà phê đều chứa đựng một chút phép màu. Hãy cùng khám phá câu chuyện đằng sau không gian đặc biệt này."
                            data-en="At Always Café, we believe every cup of coffee holds a touch of magic. Let's explore the story behind this special place."></span>
                    </p>

                    <div class="mt-8 flex flex-wrap gap-4">
                        <a href="{{ route('user.menu.index') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-gradient-to-r from-amber-400 via-yellow-500 to-amber-600 text-black font-semibold shadow-[0_0_28px_rgba(212,175,55,.35)] hover:shadow-[0_0_44px_rgba(212,175,55,.5)] transition-all duration-500 focus-ring">
                            <span data-vi="Khám phá Thực đơn" data-en="Explore Menu"></span>
                            <i data-lucide="arrow-right" class="w-5 h-5"></i>
                        </a>
                        <a href="{{ route('user.booking.tarot') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 rounded-full border-2 border-white/15 text-white hover:bg-white/10 transition-all duration-300 focus-ring">
                            <span data-vi="Đặt Tarot" data-en="Book Tarot"></span>
                            <i data-lucide="calendar" class="w-5 h-5 opacity-90"></i>
                        </a>
                    </div>
                </div>

                <div class="relative">
                    <div class="hp-glass rounded-3xl p-4 lg:p-5 hp-shadow-soft">
                        <img src="https://images.unsplash.com/photo-1517705008128-361805f42e86?q=80&w=1200&auto=format&fit=crop"
                            alt="Our magical café space" class="rounded-2xl w-full h-[420px] object-cover">
                    </div>
                    <div class="absolute -bottom-6 -left-6 w-28 h-28 bg-amber-400/20 blur-2xl rounded-full"></div>
                    <div class="absolute -top-6 -right-6 w-24 h-24 bg-purple-500/20 blur-2xl rounded-full"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== OUR STORY (TIMELINE) ===== --}}
    <section class="py-20 bg-gradient-to-b from-black to-[#0f0f10]">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="font-['Playfair_Display'] text-4xl lg:text-5xl font-bold hp-gradient-text">
                    <span data-vi="Hành Trình & Tinh Thần" data-en="Journey & Spirit"></span>
                </h2>
                <p class="mt-3 text-gray-400">
                    <span data-vi="Những chặng đường được viết bằng hương thơm và cảm hứng"
                        data-en="The journey written with aroma and inspiration"></span>
                </p>
            </div>

            <div class="relative hp-timeline-line">
                <div class="grid md:grid-cols-2 gap-10">
                    @php
                        $stops = [
                            [
                                'badge' => ['vi' => 'Chặng I', 'en' => 'Stage I'],
                                'title' => ['vi' => 'Khởi nguồn phép màu', 'en' => 'The Origin of Magic'],
                                'desc' => [
                                    'vi' =>
                                        'Always Café ra đời từ niềm đam mê pha chế và mong muốn tạo nên không gian đặc biệt cho cộng đồng yêu cà phê và phép thuật.',
                                    'en' =>
                                        'Always Café was born from a passion for brewing and a desire to create a special space for the coffee and magic-loving community.',
                                ],
                            ],
                            [
                                'badge' => ['vi' => 'Chặng II', 'en' => 'Stage II'],
                                'title' => ['vi' => 'Gieo hương vị', 'en' => 'Planting Flavors'],
                                'desc' => [
                                    'vi' =>
                                        'Mỗi tách cà phê, mỗi trải bài Tarot đều được chăm chút tỉ mỉ, mang đến trải nghiệm độc đáo và khó quên.',
                                    'en' =>
                                        'Every cup of coffee, every Tarot reading is meticulously crafted to deliver a unique and unforgettable experience.',
                                ],
                            ],
                            [
                                'badge' => ['vi' => 'Chặng III', 'en' => 'Stage III'],
                                'title' => ['vi' => 'Kết nối & sẻ chia', 'en' => 'Connect & Share'],
                                'desc' => [
                                    'vi' =>
                                        'Những buổi workshop, lần trải bài, và cuộc trò chuyện thân tình tạo nên mạch cộng đồng ấm áp.',
                                    'en' =>
                                        'Workshops, readings, and heartfelt conversations create a warm community bond.',
                                ],
                            ],
                            [
                                'badge' => ['vi' => 'Chặng IV', 'en' => 'Stage IV'],
                                'title' => ['vi' => 'Tiếp nối phép màu', 'en' => 'Continuing the Magic'],
                                'desc' => [
                                    'vi' =>
                                        'Không ngừng học hỏi, làm mới trải nghiệm để mỗi lần ghé là một lần tìm thấy điều kỳ diệu nho nhỏ.',
                                    'en' =>
                                        'Never stop learning and refreshing experiences so that every visit is a moment of discovering something wonderful.',
                                ],
                            ],
                        ];
                    @endphp

                    @foreach ($stops as $i => $e)
                        <div class="{{ $i % 2 === 0 ? 'md:col-start-1' : 'md:col-start-2' }}">
                            <div class="relative pl-10 md:pl-12">
                                <div
                                    class="absolute left-0 top-2 w-8 h-8 rounded-full bg-amber-400/20 border border-amber-300/40 grid place-items-center">
                                    <div class="w-2.5 h-2.5 rounded-full bg-amber-300"></div>
                                </div>
                                <div
                                    class="hp-glass rounded-2xl p-6 hover:translate-y-[-2px] transition-all duration-500 hp-card">
                                    <div class="flex items-center gap-3">
                                        <span
                                            class="text-xs px-3 py-1 rounded-full bg-white/10 text-amber-200 border border-white/10"
                                            data-vi="{{ $e['badge']['vi'] }}" data-en="{{ $e['badge']['en'] }}">
                                        </span>
                                        <h3 class="text-xl font-semibold text-white"><span
                                                data-vi="{{ $e['title']['vi'] }}"
                                                data-en="{{ $e['title']['en'] }}"></span></h3>
                                    </div>
                                    <p class="mt-3 text-gray-300"><span data-vi="{{ $e['desc']['vi'] }}"
                                            data-en="{{ $e['desc']['en'] }}"></span></p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ===== VALUES ===== --}}
    <section class="py-20 bg-black">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="font-['Playfair_Display'] text-4xl lg:text-5xl font-bold hp-gradient-text">
                    <span data-vi="Giá Trị Cốt Lõi" data-en="Core Values"></span>
                </h2>
                <p class="mt-3 text-gray-400">
                    <span data-vi="Ba điều chúng tôi không bao giờ thỏa hiệp"
                        data-en="Three things we never compromise on"></span>
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                @php
                    $values = [
                        [
                            'icon' => 'wand-2',
                            'title' => ['vi' => 'Thủ công & Chân thực', 'en' => 'Handcrafted & Authentic'],
                            'desc' => [
                                'vi' => 'Mỗi tách cà phê và trải bài Tarot đều được tạo nên với tâm huyết và sự tỉ mỉ.',
                                'en' =>
                                    'Every cup of coffee and Tarot reading is crafted with passion and meticulous care.',
                            ],
                        ],
                        [
                            'icon' => 'heart',
                            'title' => ['vi' => 'Cộng đồng & Tôn trọng', 'en' => 'Community & Respect'],
                            'desc' => [
                                'vi' => 'Không gian an toàn, ấm áp, tôn trọng sự khác biệt và khuyến khích sẻ chia.',
                                'en' => 'A safe, warm space that respects differences and encourages sharing.',
                            ],
                        ],
                        [
                            'icon' => 'stars',
                            'title' => ['vi' => 'Sáng tạo & Huyền bí', 'en' => 'Creativity & Mystery'],
                            'desc' => [
                                'vi' => 'Không ngừng thử nghiệm để mỗi lần ghé là một lần “wow”.',
                                'en' => 'Constantly experimenting to make every visit a “wow” experience.',
                            ],
                        ],
                    ];
                @endphp

                @foreach ($values as $v)
                    <div class="hp-glass rounded-2xl p-7 hp-shadow-soft transition-all duration-500 hp-card">
                        <div
                            class="w-12 h-12 rounded-2xl bg-amber-400/15 border border-amber-300/30 grid place-items-center mb-4">
                            <i data-lucide="{{ $v['icon'] }}" class="w-6 h-6 text-amber-300"></i>
                        </div>
                        <h3 class="text-white text-xl font-semibold"><span data-vi="{{ $v['title']['vi'] }}"
                                data-en="{{ $v['title']['en'] }}"></span></h3>
                        <p class="mt-2 text-gray-300"><span data-vi="{{ $v['desc']['vi'] }}"
                                data-en="{{ $v['desc']['en'] }}"></span></p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===== TEAM (ANONYMOUS) ===== --}}
    <section class="py-20 bg-gradient-to-b from-black to-[#0b0b0c]">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-6 mb-10">
                <div>
                    <h2 class="font-['Playfair_Display'] text-4xl font-bold hp-gradient-text"><span
                            data-vi="Những Người Giữ Lửa" data-en="The Fire Keepers"></span></h2>
                    <p class="mt-2 text-gray-400"><span data-vi="Ẩn danh để câu chuyện được kể bằng trải nghiệm"
                            data-en="Anonymous to let the story be told through experience"></span></p>
                </div>
                <a href="{{ route('user.contact.create') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full border border-white/15 text-white hover:bg-white/10 transition focus-ring">
                    <span data-vi="Liên hệ với chúng tôi" data-en="Contact Us"></span>
                    <i data-lucide="mail" class="w-5 h-5"></i>
                </a>
            </div>

            @php
                $anonymousTeam = [
                    [
                        'role' => ['vi' => 'Barista • Thủ công', 'en' => 'Barista • Handcrafted'],
                        'desc' => [
                            'vi' => 'Lắng nghe từng hạt cà phê để tìm điểm cân bằng giữa hương và nhiệt.',
                            'en' => 'Listening to each coffee bean to find the balance between aroma and heat.',
                        ],
                        'icon' => 'cup-soda',
                    ],
                    [
                        'role' => ['vi' => 'Reader • Tarot', 'en' => 'Reader • Tarot'],
                        'desc' => [
                            'vi' => 'Giữ không gian an toàn để mỗi lá bài soi chiếu dịu dàng những điều cần nghe.',
                            'en' => 'Maintaining a safe space where each card reveals gentle truths.',
                        ],
                        'icon' => 'sparkles',
                    ],
                    [
                        'role' => ['vi' => 'Thiết kế trải nghiệm', 'en' => 'Experience Design'],
                        'desc' => [
                            'vi' => 'Dệt cảm xúc vào ánh sáng, mùi hương và nhịp điệu di chuyển.',
                            'en' => 'Weaving emotions into light, scent, and movement rhythm.',
                        ],
                        'icon' => 'stars',
                    ],
                    [
                        'role' => ['vi' => 'Vận hành', 'en' => 'Operations'],
                        'desc' => [
                            'vi' => 'Âm thầm để mọi thứ trôi chảy — từ lịch hẹn đến từng chiếc ghế êm.',
                            'en' =>
                                'Silently ensuring everything flows smoothly — from appointments to each comfortable chair.',
                        ],
                        'icon' => 'settings',
                    ],
                ];
            @endphp

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($anonymousTeam as $m)
                    <div class="hp-glass rounded-2xl overflow-hidden hp-shadow-soft p-6 flex flex-col">
                        <div
                            class="w-full h-40 rounded-xl bg-gradient-to-br from-amber-400/15 via-purple-500/10 to-rose-400/15 border border-white/10 grid place-items-center">
                            <i data-lucide="{{ $m['icon'] }}" class="w-8 h-8 text-amber-300"></i>
                        </div>
                        <div class="mt-5">
                            <h3 class="text-white font-semibold"><span data-vi="{{ $m['role']['vi'] }}"
                                    data-en="{{ $m['role']['en'] }}"></span></h3>
                            <p class="text-gray-400 text-sm mt-2"><span data-vi="{{ $m['desc']['vi'] }}"
                                    data-en="{{ $m['desc']['en'] }}"></span></p>
                            <p class="mt-3 text-xs text-gray-500 italic"><span data-vi="Ẩn danh"
                                    data-en="Anonymous"></span></p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===== LOCATION & HOURS ===== --}}
    <section class="py-20 bg-black">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-10 items-stretch">
                <div class="hp-glass rounded-2xl p-6 hp-shadow-soft">
                    <h3 class="text-white text-2xl font-semibold flex items-center gap-2">
                        <i data-lucide="map-pin" class="w-6 h-6 text-amber-300"></i>
                        <span data-vi="Địa điểm & Giờ mở cửa" data-en="Location & Hours"></span>
                    </h3>
                    <div class="mt-4 grid sm:grid-cols-2 gap-4">
                        <div class="rounded-xl p-4 bg-white/5 border border-white/10">
                            <div class="text-gray-300">
                                <span data-vi="8B Hàng Tre, Hoàn Kiếm, Hà Nội"
                                    data-en="8B Hang Tre, Hoan Kiem, Hanoi"></span>
                            </div>
                            <div class="text-gray-400 text-sm mt-1"><span data-vi="Hotline: 08 670 84 98 5"
                                    data-en="Hotline: 08 670 84 98 5"></span></div>
                        </div>
                        <div class="rounded-xl p-4 bg-white/5 border border-white/10">
                            <div class="text-gray-300"><span data-vi="Mở cửa: 08:00 — 23:00"
                                    data-en="Open: 08:00 — 23:00"></span></div>
                            <div class="text-gray-400 text-sm mt-1"><span data-vi="Mỗi ngày trong tuần"
                                    data-en="Every day of the week"></span></div>
                        </div>
                    </div>
                    <a href="https://maps.google.com/?q=8B Hàng Tre, Hoàn Kiếm, Hà Nội" target="_blank"
                        rel="noopener"
                        class="mt-5 inline-flex items-center gap-2 px-4 py-2 rounded-full border border-white/15 text-white hover:bg-white/10 transition focus-ring">
                        <span data-vi="Mở bản đồ" data-en="Open map"></span>
                        <i data-lucide="corner-up-right" class="w-5 h-5"></i>
                    </a>
                </div>

                <div class="hp-glass rounded-2xl overflow-hidden hp-shadow-soft">
                    <img src="https://images.unsplash.com/photo-1511920170033-f8396924c348?q=80&w=1200&auto=format&fit=crop"
                        alt="Always Café location preview" class="w-full h-[320px] object-cover">
                </div>
            </div>
        </div>
    </section>

    {{-- ===== CTA ===== --}}
    <section class="py-20 relative overflow-hidden bg-gradient-to-b from-[#0b0b0c] to-black">
        <div class="absolute inset-0 bg-gradient-to-r from-amber-400/10 via-rose-400/10 to-purple-500/10"></div>
        <div class="relative z-10 max-w-3xl mx-auto px-6 text-center">
            <h3 class="font-['Playfair_Display'] text-4xl font-bold hp-gradient-text"><span
                    data-vi="Cùng tạo nên phép màu?" data-en="Let's create magic together?"></span></h3>
            <p class="mt-3 text-gray-300"><span data-vi="Liên hệ đặt bàn, workshop riêng, hoặc hợp tác sự kiện."
                    data-en="Contact to book a table, private workshop, or event collaboration."></span></p>
            <div class="mt-7 flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('user.contact.create') }}"
                    class="inline-flex items-center gap-2 px-8 py-4 rounded-full bg-gradient-to-r from-amber-400 via-yellow-500 to-amber-600 text-black font-semibold shadow-[0_0_30px_rgba(212,175,55,.35)] hover:shadow-[0_0_50px_rgba(212,175,55,.5)] transition-all duration-500 focus-ring">
                    <span data-vi="Liên hệ chúng tôi" data-en="Contact us"></span>
                    <i data-lucide="send" class="w-5 h-5"></i>
                </a>
                <a href="{{ route('user.workshops.index') }}"
                    class="inline-flex items-center gap-2 px-8 py-4 rounded-full border-2 border-white/15 text-white hover:bg-white/10 transition-all duration-300 focus-ring">
                    <span data-vi="Xem lịch workshop" data-en="View workshop schedule"></span>
                    <i data-lucide="calendar-days" class="w-5 h-5"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- ===== FAQ (Accordion) ===== --}}
    <section class="py-20 bg-black">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            <h3 class="font-['Playfair_Display'] text-3xl lg:text-4xl font-bold text-white text-center"><span
                    data-vi="Câu hỏi thường gặp" data-en="Frequently Asked Questions"></span></h3>
            <div class="mt-10 space-y-4">
                @php
                    $faqs = [
                        [
                            'q' => [
                                'vi' => 'Có cần đặt lịch Tarot trước không?',
                                'en' => 'Do I need to book a Tarot reading in advance?',
                            ],
                            'a' => [
                                'vi' =>
                                    'Nên đặt trước để giữ chỗ, đặc biệt vào tối cuối tuần. Tuy nhiên, chúng tôi vẫn nhận walk-in nếu reader còn trống.',
                                'en' =>
                                    'It is recommended to book in advance to secure your spot, especially on weekend evenings. However, we still accept walk-ins if the reader is available.',
                            ],
                        ],
                        [
                            'q' => [
                                'vi' => 'Có menu đồ uống không chứa caffeine?',
                                'en' => 'Is there a menu without caffeine?',
                            ],
                            'a' => [
                                'vi' =>
                                    'Có! Bạn có thể thử dòng “potion” trái cây, socola nóng, hoặc các loại trà thảo mộc.',
                                'en' => 'Yes! You can try the fruit potion, hot chocolate, or herbal teas.',
                            ],
                        ],
                        [
                            'q' => [
                                'vi' => 'Workshop phù hợp cho nhóm bao nhiêu người?',
                                'en' => 'How many people is the workshop suitable for?',
                            ],
                            'a' => [
                                'vi' =>
                                    'Từ 6–18 người là lý tưởng. Với nhóm lớn hơn, vui lòng liên hệ để chúng tôi tư vấn setup.',
                                'en' =>
                                    'From 6–18 people is ideal. For larger groups, please contact us to discuss setup.',
                            ],
                        ],
                    ];
                @endphp


                @foreach ($faqs as $i => $item)
                    <div x-data="{ open: false }" class="hp-glass rounded-2xl p-5 hp-shadow-soft">
                        <button @click="open=!open; $nextTick(()=>window.renderIcons&&window.renderIcons())"
                            class="w-full flex items-start justify-between text-left gap-6 focus-ring">
                            <div class="text-white font-medium">
                                <span data-vi="{{ $item['q']['vi'] }}" data-en="{{ $item['q']['en'] }}"></span>
                            </div>
                            <i :data-lucide="open ? 'chevron-up' : 'chevron-down'" class="w-5 h-5 text-gray-300"></i>
                        </button>
                        <div x-cloak x-show="open" x-collapse class="mt-3 text-gray-300">
                            <span data-vi="{{ $item['a']['vi'] }}" data-en="{{ $item['a']['en'] }}"></span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @push('scripts')
        {{-- Nếu project chưa load Lucide ở layout, giữ CDN này. Nếu đã có, không sao. --}}
        <script src="https://unpkg.com/lucide@latest" defer></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                window.lucide && lucide.createIcons();
            });
            window.renderIcons = () => window.lucide && window.lucide.createIcons();
        </script>
    @endpush
</x-app-layout>
