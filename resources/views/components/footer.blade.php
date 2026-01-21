@php $user = Auth::user(); @endphp

@if (!$user || $user->role !== 'admin')
    <footer
        class="relative mt-32 border-t border-amber-400/20 bg-gradient-to-b from-stone-950 via-black to-black/90 text-stone-300">
        {{-- === Magical Glow Orbs === --}}
        <div class="absolute top-0 left-1/3 w-[600px] h-[600px] bg-amber-500/10 blur-3xl rounded-full"></div>
        <div class="absolute bottom-0 right-1/4 w-[500px] h-[500px] bg-purple-500/10 blur-3xl rounded-full"></div>

        {{-- === Main Footer Grid === --}}
        <div class="relative z-10 max-w-7xl mx-auto px-6 py-16 grid md:grid-cols-4 gap-12">

            {{-- === Quick Links === --}}
            <div>
                <h4 class="hp-title text-amber-200 mb-4">
                    <span data-vi="Liên kết nhanh" data-en="Quick Links"></span>
                </h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('user.menu.index') }}" class="hover:text-amber-300 transition">
                            <span data-vi="Menu Phép Thuật" data-en="Magical Menu"></span>
                        </a>
                    </li>
                    <li><a href="{{ route('user.shop.accessories') }}" class="hover:text-amber-300 transition">
                            <span data-vi="Phụ Kiện Wizard" data-en="Wizard Accessories"></span>
                        </a></li>
                    <li><a href="{{ route('user.shop.rental') }}" class="hover:text-amber-300 transition">
                            <span data-vi="Trang Phục Cosplay" data-en="Cosplay Outfits"></span>
                        </a></li>
                    <li><a href="{{ route('user.workshops.index') }}" class="hover:text-amber-300 transition">
                            <span data-vi="Workshop Sáng Tạo" data-en="Creative Workshops"></span>
                        </a></li>
                    <li><a href="{{ route('user.booking.tarot') }}" class="hover:text-amber-300 transition">
                            <span data-vi="Đặt Lịch Tarot" data-en="Book Tarot Reading"></span>
                        </a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-amber-300 transition"></a></li>
                    <span data-vi="Về Chúng Tôi" data-en="About Us"></span>
                    </a></li>
                    <li><a href="{{ route('user.news.index') }}" class="hover:text-amber-300 transition">
                            <span data-vi="Tin Tức & Sự Kiện" data-en="News & Events"></span>
                        </a></li>
                </ul>
            </div>

            {{-- === Contact Info === --}}
            <div>
                <h4 class="hp-title text-amber-200 mb-4">
                    <span data-vi="Thông tin liên hệ" data-en="Contact Information"></span>
                </h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-center gap-2">
                        <i data-lucide="map-pin" class="w-4 h-4 text-amber-300"></i>
                        <span data-vi="8B Hàng Tre, Hoàn Kiếm, Hà Nội" data-en="8B Hang Tre, Hoan Kiem, Hanoi"></span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i data-lucide="phone" class="w-4 h-4 text-amber-300"></i>
                        08 670 84 98 5
                    </li>
                    <li class="flex items-center gap-2">
                        <i data-lucide="clock" class="w-4 h-4 text-amber-300"></i>
                        <span data-vi="Thứ Hai - Chủ Nhật: 08:00 - 22:00"
                            data-en="Monday - Sunday: 08:00 AM - 10:00 PM"></span>
                    </li>
                </ul>

                {{-- === Link to Contact Form === --}}
                <div class="pt-5">
                    <a href="{{ route('user.contact.create') }}"
                        class="inline-flex items-center gap-2 text-amber-300/90 hover:text-amber-100 
                  font-medium text-sm transition-all duration-300 group">
                        <i data-lucide="mail"
                            class="w-4 h-4 text-amber-300 group-hover:rotate-6 transition-transform"></i>
                        <span data-vi="Liên hệ với chúng tôi" data-en="Contact Us"></span>
                        <span
                            class="inline-block w-0 group-hover:w-5 h-[1px] bg-amber-300 transition-all duration-300"></span>
                    </a>
                </div>
            </div>

            {{-- === Feedback Form === --}}
            <div>
                <h4 class="hp-title text-amber-200 mb-4"><span data-vi="Gửi phản hồi" data-en="Send Feedback"></span>
                </h4>
                <form x-data="{ rating: 5 }" class="flex flex-col gap-3" action="{{ route('user.feedback.store') }}"
                    method="POST">
                    <input type="hidden" name="rating" :value="rating">
                    @csrf
                    <input type="text" name="name" placeholder="Họ và tên"
                        class="w-full rounded-xl px-4 py-3 bg-stone-900/60 border border-amber-400/20 text-stone-200
                  focus:ring-2 focus:ring-amber-400/60 focus:outline-none transition" />
                    <textarea rows="3" name="message" placeholder="Nội dung phản hồi..."
                        class="w-full rounded-xl px-4 py-3 bg-stone-900/60 border border-amber-400/20 text-stone-200
                     focus:ring-2 focus:ring-amber-400/60 focus:outline-none transition resize-none"></textarea>

                    {{-- Star Rating --}}
                    <div class="flex items-center gap-2 pt-1">
                        @for ($i = 1; $i <= 5; $i++)
                            <button type="button" @click="rating = {{ $i }}"
                                :class="rating >= {{ $i }} ? 'text-amber-400' : 'text-stone-500'"
                                class="transition">
                                <i data-lucide="star" class="w-5 h-5"></i>
                            </button>
                        @endfor
                        <span class="text-xs text-stone-400/70 ml-2"><span data-vi="(Đánh giá)"
                                data-en="(Rating)"></span></span>
                    </div>

                    <button type="submit" x-data="loadingButton" @click="handleClick" data-loading
                        class="hp-btn-primary px-5 py-3 rounded-xl bg-gradient-to-r from-amber-400 via-yellow-500 to-amber-600
                   text-black font-semibold text-sm shadow-[0_0_15px_rgba(255,215,0,0.4)] hover:scale-105 transition">
                        <span data-vi="Gửi Phản Hồi" data-en="Submit Feedback"></span>
                    </button>
                </form>

                {{-- Social Links --}}
                <div class="flex gap-4 mt-6">
                    {{-- TikTok --}}
                    <a href="https://www.tiktok.com/@alwayscafe.vn?_t=ZS-90ZLtxAEki&_r=1" target="_blank"
                        class="text-amber-300 hover:text-amber-200 transition" aria-label="TikTok - Always Café">
                        <i data-lucide="music-2" class="w-5 h-5"></i>
                    </a>

                    {{-- Instagram --}}
                    <a href="https://www.instagram.com/always.cafe?igsh=Z3B0MWNpcjd1bXVq" target="_blank"
                        class="text-amber-300 hover:text-amber-200 transition" aria-label="Instagram - Always Café">
                        <i data-lucide="instagram" class="w-5 h-5"></i>
                    </a>

                    {{-- Facebook --}}
                    <a href="https://www.facebook.com/share/1FZ4f5fgk9/?mibextid=wwXIfr" target="_blank"
                        class="text-amber-300 hover:text-amber-200 transition" aria-label="Facebook - Always Café">
                        <i data-lucide="facebook" class="w-5 h-5"></i>
                    </a>
                </div>
            </div>

            {{-- === Google Map === --}}
            <div>
                <h4 class="hp-title text-amber-200 mb-4">
                    <span data-vi="Bản đồ" data-en="Location"></span>
                </h4>

                <div
                    class="w-full h-[220px] rounded-2xl overflow-hidden
                border border-amber-400/20
                shadow-[0_0_25px_rgba(255,200,80,0.15)]">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.9787637725567!2d105.8548009!3d21.033535699999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab66d2d70177%3A0xb065ba9848f95236!2zQWx3YXlz4oCZ!5e0!3m2!1svi!2s!4v1760529654393!5m2!1svi!2s"
                        class="w-full h-full border-0" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

                <p class="mt-3 text-xs text-stone-400/80 leading-relaxed">
                    <span data-vi="Không gian phép thuật giữa lòng phố cổ Hà Nội"
                        data-en="A magical space in the heart of Hanoi Old Quarter"></span>
                </p>
            </div>
        </div>

        {{-- === Footer Bottom === --}}
        <div class="relative z-10 border-t border-amber-400/10 py-6 text-center text-sm text-stone-400/70">
            © {{ date('Y') }} <span class="text-amber-300 font-semibold">Always Café</span> — Crafted with Magic &
            Love
        </div>
    </footer>
@endif
