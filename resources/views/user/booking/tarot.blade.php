<x-app-layout>
    {{-- === Header ẩn === --}}
    <x-slot name="header">
        <div class="sr-only">
            <h1 class="font-semibold text-xl text-gray-200 leading-tight">
                Đặt lịch Tarot — Always Café
            </h1>
        </div>
    </x-slot>

    {{-- === Dark-Only Background === --}}
    <div class="relative max-w-3xl mx-auto">
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
        <div class="absolute -top-8 left-20 w-2 h-2 bg-yellow-300/60 rounded-full hp-particle-slow"
            style="animation-delay: 2s;"></div>
        <div class="absolute top-1/3 left-10 w-2.5 h-2.5 bg-purple-400/40 rounded-full hp-particle-spiral"
            style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-6 w-1 h-1 bg-amber-300/80 rounded-full hp-particle"
            style="animation-delay: 6s;"></div>
        <div class="absolute bottom-1/3 right-3 w-1.5 h-1.5 bg-yellow-400/60 rounded-full hp-particle-slow"
            style="animation-delay: 3s;"></div>
        <div class="absolute bottom-1/4 right-12 w-2 h-2 bg-amber-500/50 rounded-full hp-particle-reverse"
            style="animation-delay: 5s;"></div>
        <div class="absolute -bottom-8 left-20 w-2 h-2 bg-yellow-300/60 rounded-full hp-particle-slow"
            style="animation-delay: 2s;"></div>
        <div class="absolute -bottom-6 left-12 w-2.5 h-2.5 bg-purple-400/40 rounded-full hp-particle-spiral"
            style="animation-delay: 1s;"></div>
        <div class="absolute -bottom-4 left-6 w-1 h-1 bg-amber-300/80 rounded-full hp-particle"
            style="animation-delay: 6s;"></div>
        <div class="absolute -top-6 left-6 w-3 h-3 bg-amber-400/70 rounded-full hp-particle"
            style="animation-delay: 0s;"></div>

        {{-- Các hạt gần form hơn --}}
        <div class="absolute -top-1 -right-4 w-2 h-2 bg-yellow-400/70 rounded-full hp-particle-slow"
            style="animation-delay: 1s;"></div>
        <div class="absolute -top-1 -left-4 w-2 h-2 bg-yellow-400/70 rounded-full hp-particle-slow"
            style="animation-delay: 3s;"></div>
        <div class="absolute -top-1 -left-4 w-2 h-2 bg-yellow-400/70 rounded-full hp-particle-slow"
            style="animation-delay: 3s;"></div>
        <div class="absolute -bottom-1 -left-4 w-2 h-2 bg-yellow-400/70 rounded-full hp-particle-slow"
            style="animation-delay: 3s;"></div>
        <div class="absolute -bottom-1 -right-4 w-2 h-2 bg-yellow-400/70 rounded-full hp-particle-slow"
            style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 -left-8 w-1.5 h-1.5 bg-purple-400/50 rounded-full hp-particle-reverse"
            style="animation-delay: 4s;"></div>

        {{-- === Main Section === --}}

        <section class="min-h-screen max-w-3xl mx-auto px-6 font-[Inter] text-gray-100">
            <div class="flex items-center justify-center gap-3 mb-4">
                <svg class="w-6 h-6 text-[oklch(0.75_0.15_60)] animate-pulse" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M11 2l1.5 4.5L17 8l-4.5 1.5L11 14l-1.5-4.5L5 8l4.5-1.5L11 2z" />
                </svg>
                <svg class="w-5 h-5 text-[oklch(0.68_0.2_330)] animate-pulse" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                </svg>
                <svg class="w-4 h-4 text-[oklch(0.65_0.18_280)] animate-pulse" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M12 2l2.39 7.36L22 9.27l-6 4.38L18.18 22 12 17.77 5.82 22 8 13.65l-6-4.38 7.61-1.91L12 2z" />
                </svg>
            </div>

            {{-- === Floating Card with Magical Glow === --}}
            <div class="relative isolate group max-w-2xl mx-auto">

                {{-- ✨ Aura vòng sáng ma thuật quanh form ✨ --}}
                <div
                    class="absolute -inset-[3px] rounded-[1.6rem]
        bg-gradient-to-r from-amber-400/70 via-rose-400/60 to-purple-500/70
        blur-xl opacity-40 group-hover:opacity-70
        transition-all duration-700 ease-[cubic-bezier(0.25,0.46,0.45,0.94)]">
                </div>

                {{-- 🌌 Form Container (main glass card) --}}
                <form action="{{ route('user.booking.store') }}" method="POST"
                    class="relative z-10 hp-card p-10 rounded-3xl border border-white/10
               backdrop-blur-2xl bg-gradient-to-b from-[#121212]/80 via-[#0e0e0e]/80 to-[#080808]/90
               shadow-[0_0_60px_rgba(212,175,55,0.1)] transition-all duration-700 ease-[var(--apple-ease)]
               hover:shadow-[0_0_80px_rgba(212,175,55,0.2)]">
                    @csrf
                    <input type="hidden" name="type" value="tarot">
                    <input type="hidden" name="user_id" value="{{ auth()?->id() }}">

                    {{-- 🕯️ Header --}}
                    <header class="text-center mb-10">
                        <h2
                            class="text-4xl md:text-5xl font-[Playfair_Display] font-semibold tracking-tight
               bg-clip-text text-transparent bg-gradient-to-br from-amber-400 via-rose-400 to-purple-400
               drop-shadow-[0_3px_10px_rgba(0,0,0,0.4)] animate-[fade-in-down_1s_ease-out]
               flex items-center justify-center gap-3">
                            <i data-lucide="sparkles" class="w-8 h-8 text-amber-400 animate-pulse"></i>
                            <span data-vi="Đặt Lịch Xem Tarot" data-en="Book a Tarot Reading"></span>
                            <i data-lucide="sparkles" class="w-8 h-8 text-rose-400 animate-pulse"></i>
                        </h2>
                        <p class="mt-4 text-gray-200 text-lg leading-relaxed animate-[fade-in-up_1.2s_ease-out]">
                            <span data-vi="Nơi những lá bài tiết lộ điều bạn cần biết !"
                                data-en="Where the cards reveal what you need to know !"></span>
                        </p>
                    </header>

                    {{-- 🪄 Form Fields --}}
                    <div class="space-y-6 animate-[fade-in_1.4s_ease-out]">
                        {{-- Name & Phone --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Full Name --}}
                            <div class="space-y-2">
                                <label for="name" class="text-sm font-medium text-gray-200">
                                    <span data-vi="Họ và tên" data-en="Full Name"></span>
                                </label>

                                <div class="relative">
                                    <i data-lucide="user"
                                        class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-amber-300/80"></i>

                                    <input type="text" id="name" name="name"
                                        value="{{ old('name', auth()->user()?->name) }}"
                                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-700/60 bg-gray-900/60
                       text-gray-100 placeholder-amber-300/70
                       focus:ring-2 focus:ring-amber-400/70 focus:border-amber-400
                       transition-all duration-300 shadow-inner"
                                        data-placeholder-vi="Nhập họ và tên" data-placeholder-en="Enter full name">
                                </div>
                            </div>

                            {{-- Email (chỉ khi chưa đăng nhập) --}}
                            @guest
                                <div class="space-y-2">
                                    <label for="email" class="text-sm font-medium text-gray-200">
                                        <span data-vi="Email" data-en="Email"></span>
                                    </label>

                                    <div class="relative">
                                        <i data-lucide="mail"
                                            class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-purple-300/80"></i>

                                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                                            required
                                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-700/60 bg-gray-900/60
                       text-gray-100 placeholder-amber-300/70
                       focus:ring-2 focus:ring-purple-400/70 focus:border-purple-400
                       transition-all duration-300 shadow-inner"
                                            data-placeholder-vi="Nhập email của bạn"
                                            data-placeholder-en="Enter your email" />
                                    </div>
                                </div>
                            @endguest

                            {{-- Phone Number --}}
                            <div class="space-y-2">
                                <label for="phone" class="text-sm font-medium text-gray-200">
                                    <span data-vi="Số điện thoại" data-en="Phone Number"></span>
                                </label>

                                <div class="relative">
                                    <i data-lucide="phone"
                                        class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-rose-300/80"></i>

                                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-700/60 bg-gray-900/60
                       text-gray-100 placeholder-amber-300/70
                       focus:ring-2 focus:ring-rose-400/70 focus:border-rose-400
                       transition-all duration-300 shadow-inner"
                                        data-placeholder-vi="Nhập số điện thoại"
                                        data-placeholder-en="Enter phone number">
                                </div>
                            </div>
                        </div>
                        {{-- Date with Flatpickr --}}
                        <div class="space-y-2">
                            <label for="booking_date" class="text-sm font-medium text-gray-200">
                                <span data-vi="Ngày xem" data-en="Reading Date"></span>
                            </label>
                            <div class="relative">
                                <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-amber-300/80"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M8 7V3m8 4V3M4 11h16M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2z" />
                                </svg>
                                <input type="text" id="booking_date" name="booking_date" required
                                    data-placeholder-vi="Chọn ngày" data-placeholder-en="Select date"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-700/60 bg-gray-900/60
             text-gray-100 placeholder-amber-300/70
             focus:ring-2 focus:ring-amber-400/70 focus:border-amber-400
             transition-all duration-300 shadow-inner" />
                            </div>
                        </div>

                        {{-- Time with Flatpickr --}}
                        <div class="space-y-2">
                            <label for="booking_time" class="text-sm font-medium text-gray-200">
                                <span data-vi="Giờ xem" data-en="Reading Time"></span>
                            </label>
                            <div class="relative">
                                <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-rose-300/80"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z" />
                                </svg>
                                <input type="text" id="booking_time" name="booking_time" required
                                    data-placeholder-vi="Chọn giờ" data-placeholder-en="Select time"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-700/60 bg-gray-900/60
             text-gray-100 placeholder-amber-300/70
             focus:ring-2 focus:ring-rose-400/70 focus:border-rose-400
             transition-all duration-300 shadow-inner" />
                            </div>
                        </div>

                        {{-- People Count --}}
                        <div class="space-y-2">
                            <label for="people_count" class="text-sm font-medium text-gray-200">
                                <span data-vi="Số người tham gia" data-en="Number of Participants"></span>
                            </label>
                            <input type="number" name="people_count" id="people_count" min="1" required
                                class="w-full rounded-xl border border-gray-700/60 bg-gray-900/60
                           text-gray-100 placeholder-gray-500
                           focus:ring-2 focus:ring-purple-400/70 focus:border-purple-400
                           transition-all duration-300 px-4 py-3
                           shadow-inner hover:shadow-[0_0_12px_rgba(155,102,255,0.2)]" />
                        </div>

                        {{-- Note --}}
                        <div class="space-y-2">
                            <label for="note" class="text-sm font-medium text-gray-200">
                                <span data-vi="Ghi chú thêm" data-en="Additional Notes"></span>
                            </label>
                            <textarea name="note" id="note" rows="4"
                                class="w-full rounded-xl border border-gray-700/60 bg-gray-900/60
                           text-gray-100 placeholder-amber-300/70
                           focus:ring-2 focus:ring-amber-400/70 focus:border-amber-400
                           transition-all duration-300 px-4 py-3
                           shadow-inner hover:shadow-[0_0_12px_rgba(212,175,55,0.2)]"
                                data-placeholder-vi="Ví dụ: muốn chỗ yên tĩnh, ngồi gần cửa sổ, v.v..."
                                data-placeholder-en="Example: want a quiet spot, sit near the window, etc..."></textarea>
                        </div>
                    </div>

                    {{-- 🪄 Submit Button --}}
                    <div class="text-center pt-8">
                        <button type="submit" x-data="loadingButton" @click="handleClick" data-loading
                            class="relative inline-flex items-center justify-center px-10 py-3.5
                       text-lg font-semibold text-white rounded-full overflow-hidden
                       bg-gradient-to-r from-amber-400 via-rose-400 to-purple-500
                       shadow-[0_0_20px_rgba(212,175,55,0.4)]
                       hover:shadow-[0_0_35px_rgba(255,215,0,0.5)]
                       hover:scale-105 active:scale-95
                       transition-all duration-500 ease-[var(--apple-ease)]">
                            <span class="relative z-10">
                                <span data-vi="Đặt Lịch Xem Tarot" data-en="Book Tarot Reading"></span>
                            </span>
                            {{-- Animated Glow Layer --}}
                            <span
                                class="absolute inset-0 bg-gradient-to-r from-amber-300/30 via-rose-300/30 to-purple-400/30 blur-xl opacity-0 group-hover:opacity-100 transition-all duration-700 ease-[var(--apple-ease)]"></span>
                        </button>
                    </div>

                    {{-- Back --}}
                    <div class="flex justify-center pt-6">
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center gap-2 text-stone-300/80 hover:text-amber-300 transition-colors text-sm font-medium">
                            <i data-lucide="arrow-left-circle" class="w-5 h-5"></i>
                            <span data-vi="Quay lại" data-en="Back to Dashboard"></span>
                        </a>
                    </div>
                </form>
                <!-- 🪄 Magical Mist (visible version) -->
                <div aria-hidden="true" class="absolute inset-0 z-[] overflow-hidden rounded-3xl pointer-events-none">
                    <div
                        class="absolute -inset-[40px] animate-[float-light_10s_ease-in-out_infinite]
        bg-[radial-gradient(circle_at_30%_40%,rgba(255,215,0,0.18),transparent_60%)]
        blur-2xl opacity-80 mix-blend-screen">
                    </div>

                    <div
                        class="absolute -inset-[60px] animate-[float-light_12s_ease-in-out_infinite_reverse]
        bg-[radial-gradient(circle_at_70%_60%,rgba(255,105,180,0.15),transparent_70%)]
        blur-2xl opacity-70 mix-blend-screen">
                    </div>

                    <div
                        class="absolute -inset-[80px] animate-[float-light_16s_linear_infinite]
        bg-[radial-gradient(circle_at_50%_80%,rgba(138,43,226,0.12),transparent_70%)]
        blur-3xl opacity-70 mix-blend-screen">
                    </div>

                    <div
                        class="absolute -inset-[40px] blur-2xl opacity-60 group-hover:opacity-90 transition-all duration-1000
    bg-[radial-gradient(circle_at_30%_40%,rgba(255,215,0,0.18),transparent_60%)]
    animate-[float-light_10s_ease-in-out_infinite] mix-blend-screen">
                    </div>
                </div>

            </div>
        </section>
    </div>

    {{-- === Animations === --}}
    <style>
        @keyframes float-light {
            0% {
                transform: translate(0, 0) scale(1);
                opacity: 0.6;
            }

            25% {
                transform: translate(10px, -15px) scale(1.05);
                opacity: 0.8;
            }

            50% {
                transform: translate(-20px, 10px) scale(0.95);
                opacity: 0.7;
            }

            75% {
                transform: translate(15px, 20px) scale(1.02);
                opacity: 0.85;
            }

            100% {
                transform: translate(0, 0) scale(1);
                opacity: 0.6;
            }
        }

        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fade-in-down {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <canvas id="starfield" class="fixed inset-0 -z-30 opacity-40 pointer-events-none"></canvas>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Date picker
            flatpickr("#booking_date", {
                dateFormat: "d-m-Y", // 31-12-2025
                minDate: "today", // không cho chọn quá khứ
                disableMobile: true, // luôn dùng popup flatpickr (đồng nhất)
                // locale: "vn",          // tuỳ chọn: thêm locale nếu bạn load file locale
            });

            // Time picker
            flatpickr("#booking_time", {
                enableTime: true,
                noCalendar: true,
                time_24hr: true,
                minuteIncrement: 15,
                dateFormat: "H:i", // 18:30
                disableMobile: true
            });
        });

        document.addEventListener("DOMContentLoaded", () => {
            const canvas = document.getElementById("starfield");
            const ctx = canvas.getContext("2d");
            let stars = [];
            const numStars = 120;

            function resize() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            }
            window.addEventListener("resize", resize);
            resize();

            for (let i = 0; i < numStars; i++) {
                stars.push({
                    x: Math.random() * canvas.width,
                    y: Math.random() * canvas.height,
                    r: Math.random() * 1.2,
                    o: 0.3 + Math.random() * 0.7,
                    s: 0.2 + Math.random() * 0.5
                });
            }

            function animate() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                for (let star of stars) {
                    ctx.beginPath();
                    ctx.arc(star.x, star.y, star.r, 0, 2 * Math.PI);
                    ctx.fillStyle = `rgba(255, 255, 255, ${star.o})`;
                    ctx.fill();
                    star.y += star.s;
                    if (star.y > canvas.height) {
                        star.y = 0;
                        star.x = Math.random() * canvas.width;
                    }
                }
                requestAnimationFrame(animate);
            }
            animate();
        });
    </script>
</x-app-layout>
