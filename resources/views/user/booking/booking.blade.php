<x-app-layout>
    {{-- === Header ẩn === --}}
    <x-slot name="header">
        <div class="sr-only">
            <h1 class="font-semibold text-xl text-gray-200 leading-tight">
                Đặt chỗ — Always Café
            </h1>
        </div>
    </x-slot>

    {{-- === Wrapper (giống Tarot) === --}}
    <div class="relative max-w-3xl mx-auto px-6">

        {{-- ✨ Particles (giữ class hp-particle của bạn) --}}
        <div class="absolute -top-6 -right-6 w-3 h-3 bg-amber-400/70 rounded-full hp-particle"
            style="animation-delay: 0s;"></div>
        <div class="absolute -top-2 -right-12 w-1.5 h-1.5 bg-yellow-300/60 rounded-full hp-particle-slow"
            style="animation-delay: 2s;"></div>
        <div class="absolute top-1/4 -left-4 w-2 h-2 bg-amber-500/50 rounded-full hp-particle-reverse"
            style="animation-delay: 4s;"></div>
        <div class="absolute top-1/3 -right-8 w-2.5 h-2.5 bg-purple-400/40 rounded-full hp-particle-spiral"
            style="animation-delay: 1s;"></div>
        <div class="absolute -bottom-6 -right-6 w-3 h-3 bg-amber-400/70 rounded-full hp-particle"
            style="animation-delay: 4s;"></div>
        <div class="absolute -bottom-6 left-8 w-2.5 h-2.5 bg-purple-400/40 rounded-full hp-particle-spiral"
            style="animation-delay: 7s;"></div>

        {{-- ===== Main Section ===== --}}
        <section class="min-h-[calc(100vh-4rem)] max-w-3xl mx-auto font-[Inter] text-gray-100 flex items-center">
            <div class="relative isolate group max-w-2xl mx-auto w-full">

                {{-- ✨ Aura vòng sáng quanh card --}}
                <div
                    class="absolute -inset-[3px] rounded-[1.6rem]
                           bg-gradient-to-r from-amber-400/70 via-rose-400/60 to-purple-500/70
                           blur-xl opacity-40 group-hover:opacity-70
                           transition-all duration-700 ease-[cubic-bezier(0.25,0.46,0.45,0.94)]">
                </div>

                {{-- 🌌 Glass Card --}}
                <form action="{{ route('user.booking.store') }}" method="POST"
                    class="relative z-10 hp-card p-10 rounded-3xl border border-white/10
                           backdrop-blur-2xl bg-gradient-to-b from-[#121212]/80 via-[#0e0e0e]/80 to-[#080808]/90
                           shadow-[0_0_60px_rgba(212,175,55,0.1)]
                           transition-all duration-700 ease-[var(--apple-ease)]
                           hover:shadow-[0_0_80px_rgba(212,175,55,0.2)]">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                    {{-- 🕯️ Header --}}
                    <header class="text-center mb-10">
                        <h2
                            class="text-4xl md:text-5xl font-[Playfair_Display] font-semibold tracking-tight
                                   bg-clip-text text-transparent bg-gradient-to-br from-amber-400 via-yellow-300 to-amber-500
                                   drop-shadow-[0_3px_10px_rgba(0,0,0,0.4)]
                                   flex items-center justify-center gap-3">
                            <i data-lucide="calendar" class="w-8 h-8 text-amber-400 animate-pulse"></i>
                            <span data-vi="Đặt chỗ" data-en="Book a Session"></span>
                            <i data-lucide="sparkles" class="w-8 h-8 text-rose-400 animate-pulse"></i>
                        </h2>
                        <p class="mt-4 text-gray-200/90 text-lg leading-relaxed">
                            <span data-vi="Chọn trải nghiệm của bạn — Bàn cà phê hoặc lớp Potion."
                                data-en="Choose your experience — Coffee table or Potion class."></span>
                        </p>
                    </header>

                    {{-- Fields --}}
                    <div class="space-y-6">

                        {{-- Type --}}
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-200"><span data-vi="Loại đặt chỗ"
                                    data-en="Booking Type"></span></label>
                            <div class="relative">
                                <i data-lucide="wand-2"
                                    class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-amber-300/80"></i>

                                <select name="type" required
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-700/60 bg-gray-900/60
                                           text-gray-100
                                           focus:ring-2 focus:ring-amber-400/70 focus:border-amber-400
                                           transition-all duration-300 shadow-inner">
                                    <option value="" class="text-gray-400" data-vi="-- Chọn loại --"
                                            data-en="-- Select Type --"></option>
                                    <option value="table" data-vi="Bàn cà phê" data-en="Coffee Table"></option>
                                    <option value="potion_class" data-vi="Lớp học Potion" data-en="Potion Class">
                                    </option>
                                    <option value="event_table" data-vi="Bàn sự kiện" data-en="Event Table">
                                    </option>
                                </select>
                            </div>
                        </div>

                        {{-- Date (flatpickr giống Tarot) --}}
                        <div class="space-y-2">
                            <label for="booking_date" class="text-sm font-medium text-gray-200"><span data-vi="Ngày đặt"
                                    data-en="Booking Date"></span></label>
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

                        {{-- Time (flatpickr giống Tarot) --}}
                        <div class="space-y-2">
                            <label for="booking_time" class="text-sm font-medium text-gray-200"><span data-vi="Giờ đặt"
                                    data-en="Booking Time"></span></label>
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

                        {{-- People --}}
                        <div class="space-y-2">
                            <label for="people_count" class="text-sm font-medium text-gray-200"><span
                                    data-vi="Số người" data-en="Number of People"></span></label>
                            <div class="relative">
                                <i data-lucide="users"
                                    class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-purple-300/80"></i>

                                <input type="number" name="people_count" id="people_count" min="1"
                                    value="1" required
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-700/60 bg-gray-900/60
                                           text-gray-100
                                           focus:ring-2 focus:ring-purple-400/70 focus:border-purple-400
                                           transition-all duration-300 shadow-inner" />
                            </div>
                        </div>

                        {{-- Note --}}
                        <div class="space-y-2">
                            <label for="note" class="text-sm font-medium text-gray-200"><span
                                    data-vi="Ghi chú (tuỳ chọn)" data-en="Note (optional)"></span></label>
                            <textarea name="note" id="note" rows="4"
                                class="w-full rounded-xl border border-gray-700/60 bg-gray-900/60
                                       text-gray-100 placeholder-amber-300/70
                                       focus:ring-2 focus:ring-amber-400/70 focus:border-amber-400
                                       transition-all duration-300 px-4 py-3 shadow-inner"
                                data-placeholder-vi="Ví dụ: muốn chỗ yên tĩnh, ngồi gần cửa sổ, v.v..."
                                data-placeholder-en="Example: want a quiet spot, sit near the window, etc..."></textarea>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="text-center pt-8">
                        <button type="submit" x-data="loadingButton" @click="handleClick" data-loading
                            class="relative inline-flex items-center justify-center px-10 py-3.5
                                   text-lg font-semibold text-white rounded-full overflow-hidden
                                   bg-gradient-to-r from-amber-400 via-rose-400 to-purple-500
                                   shadow-[0_0_20px_rgba(212,175,55,0.4)]
                                   hover:shadow-[0_0_35px_rgba(255,215,0,0.5)]
                                   hover:scale-105 active:scale-95
                                   transition-all duration-500 ease-[var(--apple-ease)]">
                            <span class="relative z-10"><span data-vi="Xác nhận đặt chỗ"
                                    data-en="Confirm Booking"></span></span>
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

                {{-- 🌫️ Mist layer (giống Tarot) --}}
                <div aria-hidden="true" class="absolute inset-0 overflow-hidden rounded-3xl pointer-events-none">
                    <div
                        class="absolute -inset-[40px] animate-[float-light_10s_ease-in-out_infinite]
                                bg-[radial-gradient(circle_at_30%_40%,rgba(255,215,0,0.18),transparent_60%)]
                                blur-2xl opacity-70 mix-blend-screen">
                    </div>
                    <div
                        class="absolute -inset-[60px] animate-[float-light_12s_ease-in-out_infinite_reverse]
                                bg-[radial-gradient(circle_at_70%_60%,rgba(255,105,180,0.15),transparent_70%)]
                                blur-2xl opacity-60 mix-blend-screen">
                    </div>
                    <div
                        class="absolute -inset-[80px] animate-[float-light_16s_linear_infinite]
                                bg-[radial-gradient(circle_at_50%_80%,rgba(138,43,226,0.12),transparent_70%)]
                                blur-3xl opacity-60 mix-blend-screen">
                    </div>
                </div>

            </div>
        </section>
    </div>

    {{-- ✅ CHỈ 1 canvas starfield thôi --}}
    <canvas id="starfield" class="fixed inset-0 -z-30 opacity-40 pointer-events-none"></canvas>

    {{-- Flatpickr + Starfield --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Date picker (giống Tarot)
            flatpickr("#booking_date", {
                dateFormat: "d-m-Y",
                minDate: "today",
                disableMobile: true,
            });

            // Time picker (giống Tarot)
            flatpickr("#booking_time", {
                enableTime: true,
                noCalendar: true,
                time_24hr: true,
                minuteIncrement: 15,
                dateFormat: "H:i",
                disableMobile: true
            });

            // Starfield (nhẹ, ổn định)
            const canvas = document.getElementById("starfield");
            if (!canvas) return;
            const ctx = canvas.getContext("2d");

            let stars = [];
            const numStars = 140;

            function resize() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            }
            window.addEventListener("resize", resize);
            resize();

            stars = Array.from({
                length: numStars
            }, () => ({
                x: Math.random() * canvas.width,
                y: Math.random() * canvas.height,
                r: Math.random() * 1.2,
                o: 0.25 + Math.random() * 0.75,
                s: 0.15 + Math.random() * 0.55
            }));

            function animate() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                for (const star of stars) {
                    ctx.beginPath();
                    ctx.arc(star.x, star.y, star.r, 0, Math.PI * 2);
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

    <style>
        @keyframes float-light {
            0% {
                transform: translate(0, 0) scale(1);
                opacity: .6;
            }

            25% {
                transform: translate(10px, -15px) scale(1.05);
                opacity: .8;
            }

            50% {
                transform: translate(-20px, 10px) scale(.95);
                opacity: .7;
            }

            75% {
                transform: translate(15px, 20px) scale(1.02);
                opacity: .85;
            }

            100% {
                transform: translate(0, 0) scale(1);
                opacity: .6;
            }
        }

        /* optional: làm select giống input */
        select {
            appearance: none;
        }
    </style>
</x-app-layout>
