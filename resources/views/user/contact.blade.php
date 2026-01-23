<x-app-layout>
    <x-slot name="header">
        <div class="sr-only">
            <h1>Liên hệ — Always Café</h1>
        </div>
    </x-slot>

    {{-- === Magical Background === --}}
    <div class="relative isolate min-h-screen">
        <canvas id="starfield" class="absolute inset-0 w-full h-full"></canvas>

        {{-- Glowing Orbs --}}
        <div class="absolute top-0 left-1/3 w-[600px] h-[600px] bg-amber-500/20 blur-3xl rounded-full"></div>
        <div class="absolute bottom-0 right-1/4 w-[500px] h-[500px] bg-purple-500/20 blur-3xl rounded-full"></div>

        {{-- === Contact Card === --}}
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
                        <span data-vi="Liên hệ" data-en="Contact"></span>
                    </h1>
                    <p class="text-stone-300/80 mt-3 text-sm md:text-base">
                        <span data-vi="Chúng tôi rất vui khi được lắng nghe bạn!" data-en="We'd love to hear from you! Send us a message."></span>
                    </p>
                </div>

                {{-- === Contact Form === --}}
                <form method="POST" action="{{ route('user.contact.store') }}" class="space-y-6">
                    @csrf

                    {{-- Name --}}
                    <div>
                        <label class="hp-caption text-amber-200/90 mb-2 block"><span data-vi="Họ và Tên" data-en="Full Name"></span>
                        <input type="text" name="name" data-placeholder-vi="Nhập họ và tên của bạn" data-placeholder-en="Enter your full name" required
                            class="w-full px-4 py-3 rounded-2xl border border-amber-400/30 
                                   bg-stone-900/70 text-amber-500 placeholder-amber-300/40
                                   focus:ring-2 focus:ring-amber-400/70 focus:border-amber-400/70
                                   focus:outline-none transition-all duration-300">
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="hp-caption text-amber-200/90 mb-2 block"><span data-vi="Email" data-en="Email"></span></label>
                        <input type="email" name="email" data-placeholder-vi="Nhập địa chỉ email" data-placeholder-en="Enter your email address" required
                            class="w-full px-4 py-3 rounded-2xl border border-amber-400/30 
                                   bg-stone-900/70 text-amber-500 placeholder-amber-300/40
                                   focus:ring-2 focus:ring-amber-400/70 focus:border-amber-400/70
                                   focus:outline-none transition-all duration-300">
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label class="hp-caption text-amber-200/90 mb-2 block"><span data-vi="Số điện thoại" data-en="Phone Number"></span></label>
                        <input type="text" name="phone" data-placeholder-vi="Nhập số điện thoại" required data-placeholder-en="Enter your phone number"
                            class="w-full px-4 py-3 rounded-2xl border border-amber-400/30 
                                   bg-stone-900/70 text-amber-500 placeholder-amber-300/40
                                   focus:ring-2 focus:ring-amber-400/70 focus:border-amber-400/70
                                   focus:outline-none transition-all duration-300">
                    </div>

                    {{-- Message --}}
                    <div>
                        <label class="hp-caption text-amber-200/90 mb-2 block"><span data-vi="Lời nhắn" data-en="Message"></span></label>
                        <textarea name="message" rows="5" data-placeholder-vi="Nhập nội dung bạn muốn gửi đến Always Café..." data-placeholder-en="Enter the message you want to send to Always Café..." required
                            class="w-full px-4 py-3 rounded-2xl border border-amber-400/30 
                                   bg-stone-900/70 text-amber-500 placeholder-amber-300/40
                                   focus:ring-2 focus:ring-amber-400/70 focus:border-amber-400/70
                                   focus:outline-none transition-all duration-300 resize-none"></textarea>
                    </div>

                    {{-- Submit --}}
                    <div class="flex justify-center pt-8">
                        <button type="submit"  x-data="loadingButton" @click="handleClick" data-loading
                            class="inline-flex items-center gap-2 rounded-2xl px-10 py-4 
                                   bg-gradient-to-r from-amber-400 via-yellow-500 to-amber-600 
                                   text-black font-semibold text-base
                                   shadow-[0_0_25px_rgba(255,215,0,0.4)] hover:shadow-[0_0_40px_rgba(255,215,0,0.6)]
                                   hover:scale-[1.05] active:scale-[0.98] transition-all duration-500 ease-out">
                            <i data-lucide="send" class="w-5 h-5"></i>
                            <span data-vi="Gửi lời nhắn" data-en="Send Message"></span>
                        </button>
                    </div>
                </form>

                {{-- === Contact Info === --}}
                <div class="text-center mt-10 space-y-3 text-[13px] text-amber-200/80">
                    <p class="flex items-center justify-center gap-2">
                        <i data-lucide="phone" class="w-4 h-4 text-amber-300"></i>
                        08 670 84 98 5
                    </p>
                    <p class="flex items-center justify-center gap-2">
                        <i data-lucide="mail" class="w-4 h-4 text-amber-300"></i>
                        <a href="mailto:alwayscafe.vn@gmail.com" class="hover:text-amber-100 transition">
                            alwayscafe.vn@gmail.com
                        </a>
                    </p>

                    <div class="flex justify-center gap-5 pt-3 text-amber-200/70">
                        <a href="https://www.tiktok.com/@alwayscafe.vn?_t=ZS-90ZLtfxAEki&_r=1" target="_blank" title="TikTok"
                           class="hover:text-amber-100 hover:scale-110 transition">
                            <i data-lucide="music" class="w-4 h-4"></i>
                        </a>
                        <a href="https://www.instagram.com/always.cafe?igsh=Z3B0MWNpcjd1bXVq" target="_blank" title="Instagram"
                           class="hover:text-amber-100 hover:scale-110 transition">
                            <i data-lucide="instagram" class="w-4 h-4"></i>
                        </a>
                        <a href="https://www.facebook.com/share/1FZ4f5fgk9/?mibextid=wwXlfr" target="_blank" title="Facebook"
                           class="hover:text-amber-100 hover:scale-110 transition">
                            <i data-lucide="facebook" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
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
                stars = Array.from({ length: 200 }, () => ({
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

    <style>
        .hp-caption {
            font-size: 13px;
            letter-spacing: 0.03em;
            font-weight: 500;
            text-transform: uppercase;
        }
        input::placeholder,
        textarea::placeholder {
            color: rgba(255, 224, 160, 0.4);
        }
    </style>
</x-app-layout>
