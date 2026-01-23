<x-app-layout>
    <x-slot name="header">
        <div class="sr-only">
            <h1>Đăng ký Workshop — Always Café</h1>
        </div>
    </x-slot>

    {{-- === Magical Background === --}}
    <div class="relative isolate min-h-screen">
        <canvas id="starfield" class="absolute inset-0 w-full h-full"></canvas>

        {{-- Glowing Orbs --}}
        <div class="absolute top-0 left-1/3 w-[600px] h-[600px] bg-amber-500/20 blur-3xl rounded-full"></div>
        <div class="absolute bottom-0 right-1/4 w-[500px] h-[500px] bg-purple-500/20 blur-3xl rounded-full"></div>

        {{-- === Registration Card === --}}
        <div class="relative z-10 max-w-3xl mx-auto px-6">
            <div
                class="hp-card backdrop-blur-2xl rounded-3xl border border-amber-400/20
                        bg-gradient-to-br from-amber-950/40 via-black/40 to-amber-950/30 
                        shadow-[0_0_35px_rgba(255,215,0,0.15)]
                        transition-all duration-700 hover:shadow-[0_0_50px_rgba(255,215,0,0.25)] p-10">

                {{-- === Title === --}}
                <div class="text-center mb-10">
                    <h1
                        class="flex items-center justify-center gap-3 text-4xl md:text-5xl 
                               font-[Playfair_Display] font-semibold bg-gradient-to-r 
                               from-amber-300 via-yellow-400 to-amber-500 bg-clip-text 
                               text-transparent drop-shadow-[0_0_10px_rgba(255,215,0,0.3)]">
                        <i data-lucide="sparkles" class="w-7 h-7 text-amber-400"></i>
                        <span data-vi="Đăng Ký Workshop" data-en="Register for Workshop"></span>
                    </h1>
                    <p class="text-stone-300/80 mt-3">
                        <span data-vi="Trải nghiệm nghệ thuật sáng tạo trong thế giới wizard cùng Always Café."
                            data-en="Experience the art of creativity in the wizard world with Always Café."></span>
                    </p>
                </div>

                {{-- === Form === --}}
                <form method="POST" action="{{ route('user.workshop_registrations.store') }}" class="space-y-6">
                    @csrf

                    {{-- Workshop (Locked / Read-only) --}}
                    <div>
                        <label class="hp-caption text-amber-200/90 mb-2 block">
                            <span data-vi="Workshop đã chọn" data-en="Selected Workshop"></span>
                        </label>

                        {{-- UI: show as read-only field --}}
                        <div
                            class="w-full px-4 py-3 rounded-2xl border border-amber-400/30 
                bg-stone-900/70 text-amber-100
                flex items-center justify-between gap-3">
                            <div class="min-w-0">
                                <div class="font-semibold truncate">
                                    {{ $match->title }}
                                </div>
                                <div class="text-sm text-amber-300/70">
                                    {{ \Carbon\Carbon::parse($match->date)->format('M d, Y') }}
                                    @if ($match->time)
                                        • {{ $match->time }}
                                    @endif
                                    @if ($match->location)
                                        • {{ $match->location }}
                                    @endif
                                </div>
                            </div>

                            <span
                                class="text-xs px-3 py-1 rounded-full bg-amber-400/10 border border-amber-400/20 text-amber-200">
                                Locked
                            </span>
                        </div>

                        {{-- IMPORTANT: send workshop_id --}}
                        <input type="hidden" name="workshop_id" value="{{ $match->id }}">
                    </div>

                    {{-- Name --}}
                    <div>
                        <label class="hp-caption text-amber-200/90 mb-2 block">
                            <span data-vi="Họ và Tên" data-en="Full Name"></span>
                            <input type="text" name="name" data-placeholder-vi="Nhập họ và tên đầy đủ"
                                data-placeholder-en="Enter your full name" required
                                class="w-full px-4 py-3 rounded-2xl border border-amber-400/30 
                                   bg-stone-900/70 text-amber-500 placeholder-amber-300/40
                                   focus:ring-2 focus:ring-amber-400/70 focus:border-amber-400/70
                                   focus:outline-none transition-all duration-300">
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="hp-caption text-amber-200/90 mb-2 block">
                            <span data-vi="Địa chỉ Email" data-en="Email Address"></span>
                        </label>
                        <input type="email" name="email" data-placeholder-vi="Nhập email của bạn"
                            data-placeholder-en="Enter your email address" required
                            class="w-full px-4 py-3 rounded-2xl border border-amber-400/30 
                                   bg-stone-900/70 text-amber-500 placeholder-amber-300/40
                                   focus:ring-2 focus:ring-amber-400/70 focus:border-amber-400/70
                                   focus:outline-none transition-all duration-300">
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label class="hp-caption text-amber-200/90 mb-2 block">
                            <span data-vi="Số điện thoại" data-en="Phone Number"></span>
                        </label>
                        <input type="text" name="phone" data-placeholder-vi="Nhập số điện thoại"
                            data-placeholder-en="Enter your phone number" required
                            class="w-full px-4 py-3 rounded-2xl border border-amber-400/30 
                                   bg-stone-900/70 text-amber-500 placeholder-amber-300/40
                                   focus:ring-2 focus:ring-amber-400/70 focus:border-amber-400/70
                                   focus:outline-none transition-all duration-300">
                    </div>

                    {{-- Note --}}
                    <div>
                        <label class="hp-caption text-amber-200/90 mb-2 block">
                            <span data-vi="Ghi chú (tuỳ chọn)" data-en="Note (Optional)"></span>
                        </label>
                        <textarea name="note" rows="4" data-placeholder-vi="Bạn muốn lưu ý gì khi tham gia workshop..."
                            data-placeholder-en="What would you like to note when attending the workshop?"
                            class="w-full px-4 py-3 rounded-2xl border border-amber-400/30 
                                   bg-stone-900/70 text-amber-500 placeholder-amber-300/40
                                   focus:ring-2 focus:ring-amber-400/70 focus:border-amber-400/70
                                   focus:outline-none transition-all duration-300"></textarea>
                    </div>

                    {{-- Submit Center --}}
                    <div class="flex justify-center pt-8">
                        <button type="submit" x-data="loadingButton" @click="handleClick" data-loading
                            class="inline-flex items-center gap-2 rounded-2xl px-10 py-4 
            bg-gradient-to-r from-amber-400 via-yellow-500 to-amber-600 
            text-black font-semibold text-base
            shadow-[0_0_25px_rgba(255,215,0,0.4)] hover:shadow-[0_0_40px_rgba(255,215,0,0.6)]
            hover:scale-[1.05] active:scale-[0.98] transition-all duration-500 ease-out">

                            <i data-lucide="ticket" class="w-5 h-5"></i>
                            <span data-vi="Đăng Ký Ngay" data-en="Register Now"></span>
                        </button>
                    </div>
                    {{-- === Back Button === --}}
                    <div class="flex justify-center pt-6">
                        <a href="{{ route('user.workshops.index') }}"
                            class="inline-flex items-center gap-2 text-stone-300/80 hover:text-amber-300 transition-colors text-sm font-medium">
                            <i data-lucide="arrow-left-circle" class="w-5 h-5"></i>
                            <span data-vi="Quay lại danh sách Workshop" data-en="Back to Workshop List"></span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- === Starfield Script === --}}
    <script>
        window.addEventListener("load", () => {
            const canvas = document.getElementById("starfield");
            if (!canvas) return;
            const ctx = canvas.getContext("2d");
            const dpr = window.devicePixelRatio || 1;
            let stars = [];

            function resize() {
                canvas.width = innerWidth * dpr;
                canvas.height = innerHeight * dpr;
                stars = Array.from({
                    length: 200
                }, () => ({
                    x: Math.random() * canvas.width,
                    y: Math.random() * canvas.height,
                    r: Math.random() * 1.6 + 0.4,
                    a: 0.4 + Math.random() * 0.6,
                    t: Math.random() * Math.PI * 2
                }));
            }

            function draw(ts) {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                stars.forEach((s, i) => {
                    s.t += 0.015;
                    const tw = Math.sin(s.t) * 0.3 + 0.7;
                    ctx.fillStyle = `hsla(${45 + Math.sin(ts * 0.001 + i) * 15}, 80%, 80%, ${s.a * tw})`;
                    ctx.beginPath();
                    ctx.arc(s.x, s.y, s.r, 0, Math.PI * 2);
                    ctx.fill();
                });
                requestAnimationFrame(draw);
            }

            resize();
            draw(0);
            window.addEventListener("resize", resize);
        });
    </script>
</x-app-layout>
