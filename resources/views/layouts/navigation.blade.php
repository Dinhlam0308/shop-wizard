    @php $user = Auth::user(); @endphp

    <nav x-data="{
        openSearch: false,
        searchQuery: '',
        openMain: false,
        ddBooking: false,
        ddShop: false,
        ddUser: false,
        isDark: document.documentElement.classList.contains('dark'),
    }" class="fixed top-0 left-0 w-full z-[100]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">

                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}"
                        class="group inline-flex items-center gap-2.5 rounded-full
px-3 py-1.5
shadow-[0_2px_10px_rgba(0,0,0,0.1)]
hover:shadow-[0_4px_14px_rgba(0,0,0,0.15)]
transition-all duration-700 ease-in-out hover:scale-[1.08] active:scale-[0.96]">

                        <img src="{{ asset('images/Logo.png') }}" class="h-7 w-auto" alt="Logo">
                    </a>
                </div>

                {{-- === Menu giữa (ẩn nếu là admin) — hiển thị cho guest & user thường === --}}
                @if (!$user || ($user && $user->role !== 'admin'))
                    <div class="hidden md:flex items-center space-x-6 font-medium text-[15px] text-gray-100">
                        <a href="{{ route('about') }}" class="hp-navlink">
                            <span data-vi="Giới thiệu" data-en="About"></span>
                        </a>

                        {{-- Dropdown: Cửa hàng --}}
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open=!open; $nextTick(() => window.renderIcons && window.renderIcons())"
                                class="hp-navlink inline-flex items-center gap-1">
                                <span data-vi="Sản phẩm" data-en="Products"></span>
                                <i data-lucide="chevron-down" class="w-4 h-4 opacity-70"></i>
                            </button>
                            <div x-cloak x-show="open" @click.outside="open=false" x-transition
                                class="absolute left-0 mt-2 w-44 rounded-2xl overflow-hidden
                            bg-gray/80 dark:bg-[#1b1b1d]/80 backdrop-blur-2xl
                            border border-white/20 dark:border-white/10 shadow-lg">
                                <a href="{{ route('user.shop.accessories') }}"
                                    class="block px-4 py-2 hover:bg-black/5 dark:hover:bg-white/10 transition">
                                    <span data-vi="Phụ kiện" data-en="Accessories"></span>
                                </a>
                                <a href="{{ route('user.shop.rental') }}"
                                    class="block px-4 py-2 hover:bg-black/5 dark:hover:bg-white/10 transition">
                                    <span data-vi="Thuê đồ" data-en="Rental"></span>
                                </a>
                            </div>
                        </div>
                        <a href="{{ route('user.menu.index') }}" class="hp-navlink">
                            <span data-vi="Menu" data-en="Menu"></span>
                        </a>

                        <a href="{{ route('user.workshops.index') }}" class="hp-navlink">Workshop</a>

                        {{-- Dropdown: Đặt lịch --}}
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open=!open; $nextTick(() => window.renderIcons && window.renderIcons())"
                                class="hp-navlink inline-flex items-center gap-1">
                                <span data-vi="Đặt lịch" data-en="Book Now"></span>
                                <i data-lucide="chevron-down" class="w-4 h-4 opacity-70"></i>
                            </button>
                            <div x-cloak x-show="open" @click.outside="open=false" x-transition
                                class="absolute left-0 mt-2 w-44 rounded-2xl overflow-hidden
                            bg-gray/80 dark:bg-[#1b1b1d]/80 backdrop-blur-2xl
                            border border-white/20 dark:border-white/10 shadow-lg">
                                <a href="{{ route('user.booking.tarot') }}"
                                    class="block px-4 py-2 hover:bg-black/5 dark:hover:bg-white/10 transition">
                                    <span data-vi="Tarot reading" data-en="Tarot reading"></span>
                                </a>
                                <a href="{{ route('user.booking') }}"
                                    class="block px-4 py-2 hover:bg-black/5 dark:hover:bg-white/10 transition">
                                    <span data-vi="Lớp học độc dược" data-en="Potion Class"></span>
                                </a>
                                <a href="{{ route('user.booking') }}"
                                    class="block px-4 py-2 hover:bg-black/5 dark:hover:bg-white/10 transition">
                                    <span data-vi="Đặt bàn & Phòng sự kiện" data-en="Book a table & Event rooms"></span>
                                </a>
                            </div>
                        </div>

                        <a href="{{ route('user.news.index') }}" class="hp-navlink">
                            <span data-vi="Tin tức" data-en="News"></span>
                        </a>
                        <a href="{{ route('user.contact.create') }}" class="hp-navlink">
                            <span data-vi="Liên hệ" data-en="Contact"></span>
                        </a>
                    </div>
                @endif

                {{-- === Khu vực phải === --}}
                <div class="flex items-center space-x-4">

                    {{-- 🔎 Search (bung full nav) --}}
                    @if (!$user || ($user && $user->role !== 'admin'))
                        <button type="button"
                            @click="
      openSearch = !openSearch;
      if(openSearch){ openMain = false; }
      $nextTick(() => window.renderIcons && window.renderIcons());
    "
                            class="relative flex items-center justify-center w-11 h-11 rounded-full
            hover:bg-white/70 dark:hover:bg-gray-800/40
           transition-all duration-700 ease-in-out hover:scale-[1.08] active:scale-[0.96]">

                            <i data-lucide="search" class="w-5 h-5 text-gray-100 dark:text-gray-200"></i>

                        </button>
                    @endif


                    {{-- 🌗 Dark Mode (chỉ admin) --}}
                    @auth
                        @if ($user->role === 'admin')
                            <button type="button" x-init="isDark = localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches);
                            $watch('isDark', v => {
                                document.documentElement.classList.toggle('dark', v);
                                localStorage.setItem('darkMode', v);
                            });" @click="isDark = !isDark"
                                class="relative flex items-center justify-center w-11 h-11 rounded-full
            hover:bg-white/70 dark:hover:bg-gray-800/40
                            hover:shadow-[inset_0_1px_3px_rgba(255,255,255,0.4),0_4px_14px_rgba(0,0,0,0.15)]
                            transition-all duration-700 ease-in-out backdrop-blur-xl hover:scale-[1.08] active:scale-[0.96]">
                                <i data-lucide="sun" class="w-5 h-5 text-yellow-400" x-cloak x-show="!isDark"></i>
                                <i data-lucide="moon" class="w-5 h-5 text-indigo-300" x-cloak x-show="isDark"></i>
                            </button>
                        @endif
                    @endauth

                    {{-- 👤 User menu (Apple-style icon) --}}
                    @auth
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open=!open; $nextTick(() => window.renderIcons && window.renderIcons())"
                                class="group inline-flex items-center justify-center
h-10 w-10 rounded-full
hover:bg-white/70 dark:hover:bg-gray-800/40
hover:shadow-[inset_0_1px_3px_rgba(255,255,255,0.4),0_4px_14px_rgba(0,0,0,0.15)]
transition-all duration-700 ease-in-out hover:scale-[1.08] active:scale-[0.96]
text-neutral-700 dark:text-neutral-300">

                                <i data-lucide="user"
                                    class="w-5 h-5 text-gray-200
                  opacity-80 group-hover:opacity-100
                  transition-opacity duration-500"></i>
                            </button>
                            <div x-cloak x-show="open" @click.outside="open=false" x-transition
                                class="absolute right-0 mt-3 w-48 rounded-2xl overflow-hidden
                bg-white/80 dark:bg-gray-800/40
                backdrop-blur-2xl
                border border-black/5 dark:border-white/10
                shadow-[0_20px_40px_rgba(0,0,0,0.15)]">

                                <a href="{{ route('profile.edit') }}"
                                    class="flex items-center gap-2 px-4 py-2.5 text-sm
                  text-neutral-700 dark:text-neutral-200
                  hover:bg-black/5 dark:hover:bg-white/10
                  transition">
                                    <i data-lucide="user-circle" class="w-4 h-4 opacity-70"></i>
                                    <span data-vi="Hồ sơ" data-en="Profile"></span>
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center gap-2 w-full px-4 py-2.5 text-sm
                       text-neutral-700 dark:text-neutral-200
                       hover:bg-black/5 dark:hover:bg-white/10
                       transition">
                                        <i data-lucide="log-out" class="w-4 h-4 opacity-70"></i>
                                        <span data-vi="Đăng xuất" data-en="Logout"></span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth


                    {{-- 🛒 Giỏ hàng (chỉ user thường) --}}
                    @auth
                        @if ($user->role !== 'admin')
                            <a href="{{ route('cart.show') }}"
                                class="relative flex items-center justify-center w-11 h-11 rounded-full
                        hover:bg-white/70 dark:hover:bg-gray-800/40
                        hover:shadow-[inset_0_1px_3px_rgba(255,255,255,0.4),0_4px_14px_rgba(0,0,0,0.15)]
                         transition-all duration-700 ease-in-out hover:scale-[1.08] active:scale-[0.96] group">
                                <i data-lucide="shopping-bag" class="w-5 h-5 text-amber-400"></i>
                                <span
                                    class="absolute -top-1.5 -right-1.5 flex items-center justify-center
                            w-5 h-5 rounded-full bg-gradient-to-r from-amber-400 to-yellow-500
                            text-black text-xs font-semibold shadow-md">
                                    <livewire:cart-count />
                                </span>
                            </a>
                        @endif
                    @endauth

                    <button type="button" id="langToggleBtn"
                        class="relative flex items-center justify-center h-11 px-4 rounded-full
            hover:bg-white/70 dark:hover:bg-gray-800/40
            hover:shadow-[inset_0_1px_3px_rgba(255,255,255,0.4),0_4px_14px_rgba(0,0,0,0.15)]
             transition-all duration-700 ease-in-out hover:scale-[1.03] active:scale-[0.98]">
                        <span id="langLabel" class="text-sm font-semibold text-gray-200 dark:text-gray-100">VI</span>
                    </button>

                    @guest
                        <div class="hidden sm:flex items-center gap-2">
                            <a href="{{ route('login') }}"
                                class="px-4 py-2 rounded-full border border-white/30 dark:border-white/10 text-sm text-gray-100 dark:text-gray-100 hover:bg-white/60 dark:hover:bg-white/10 transition">
                                <span data-vi="Đăng nhập" data-en="Login"></span>
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="px-4 py-2 rounded-full bg-gradient-to-r from-amber-400 to-yellow-600 text-black text-sm font-semibold hover:shadow-lg hover:shadow-amber-400/40 transition">
                                    <span data-vi="Đăng ký" data-en="Register"></span>
                                </a>
                            @endif
                        </div>
                    @endguest

                    {{-- 🔽 Nút mở menu mobile --}}
                    @if (!$user || ($user && $user->role !== 'admin'))
                        <button
                            @click="openMain = !openMain; $nextTick(() => window.renderIcons && window.renderIcons())"
                            class="md:hidden flex items-center justify-center p-2 rounded-full bg-white/40 dark:bg-gray-800/40">
                            <i data-lucide="menu" class="w-6 h-6 text-gray-700 dark:text-gray-200" x-cloak
                                x-show="!openMain"></i>
                            <i data-lucide="x" class="w-6 h-6 text-gray-700 dark:text-gray-200" x-cloak
                                x-show="openMain"></i>
                        </button>
                    @endif
                </div>
            </div>
        </div>

        {{-- === Menu Mobile (guest + user thường) === --}}
        @if (!$user || ($user && $user->role !== 'admin'))
            <div x-cloak x-show="openMain" x-transition
                class="md:hidden backdrop-blur-xl bg-white/70 dark:bg-[#1b1b1d]/80 border-t border-white/10 shadow-inner">
                <div class="px-6 py-4 space-y-3 text-sm font-medium text-gray-700 dark:text-gray-200">
                    <a href="{{ route('user.menu.index') }}" class="block hover:text-amber-400">
                        <span data-vi="Menu" data-en="Menu"></span>
                    </a>
                    <a href="{{ route('user.workshops.index') }}" class="block hover:text-amber-400">
                        <span data-vi="Workshop" data-en="Workshop"></span>
                    </a>
                    <a href="{{ route('user.booking.tarot') }}" class="block hover:text-amber-400">
                        <span data-vi="Tarot Reading" data-en="Tarot Reading"></span>
                    </a>
                    <a href="{{ route('user.booking') }}" class="block hover:text-amber-400">
                        <span data-vi="Đặt lịch" data-en="Book Now"></span>
                    </a>
                    <a href="{{ route('user.shop.accessories') }}" class="block hover:text-amber-400">
                        <span data-vi="Phụ kiện" data-en="Accessories">
                        </span></a>
                    <a href="{{ route('user.shop.rental') }}" class="block hover:text-amber-400">
                        <span data-vi="Thuê đồ" data-en="Costume Rental">
                        </span>
                    </a>
                    <a href="{{ route('user.news.index') }}" class="block hover:text-amber-400">
                        <span data-vi="Tin tức" data-en="News"></span>
                    </a>
                    <a href="{{ route('user.contact.create') }}" class="block hover:text-amber-400">
                        <span data-vi="Liên hệ" data-en="Contact"></span>
                    </a>

                    @guest
                        <div class="pt-3 flex gap-2">
                            <a href="{{ route('login') }}"
                                class="flex-1 text-center px-4 py-2 rounded-full border border-white/30 dark:border-white/10 hover:bg-white/60 dark:hover:bg-white/10 transition">
                                <span data-vi="Đăng nhập" data-en="Login"></span>
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="flex-1 text-center px-4 py-2 rounded-full bg-gradient-to-r from-amber-400 to-yellow-600 text-black font-semibold hover:shadow-lg hover:shadow-amber-400/40 transition">
                                    <span data-vi="Đăng ký" data-en="Register"></span>
                                </a>
                            @endif
                        </div>
                    @endguest
                </div>
            </div>
        @endif

        {{-- ===== SEARCH OVERLAY (ONLY CLOSE CAN CLOSE) ===== --}}
        @if (!$user || ($user && $user->role !== 'admin'))
            <template x-teleport="body">
                <div x-cloak x-show="openSearch" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" class="fixed inset-0 z-[9999]">
                    {{-- Backdrop (KHÔNG click để đóng) --}}
                    <div class="absolute inset-0 bg-black/30 backdrop-blur-sm"></div>

                    {{-- Panel (đẩy xuống dưới nav) --}}
                    <div class="relative pt-20">
                        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                            <div
                                class="rounded-3xl overflow-hidden
                               bg-white/95 dark:bg-[#1b1b1d]/95 backdrop-blur-2xl
                               border border-white/20 dark:border-white/10 shadow-2xl">
                                {{-- Search bar --}}
                                <div class="p-4 sm:p-6">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-1 relative">
                                            <i data-lucide="search"
                                                class="w-5 h-5 text-gray-500 dark:text-gray-300 absolute left-4 top-1/2 -translate-y-1/2"></i>

                                            <input type="text" placeholder="Tìm theo tên phụ kiện..."
                                                x-model="searchQuery"
                                                @keydown.enter.prevent="
                                            if (searchQuery && searchQuery.trim().length > 0) {
                                                window.location.href = '{{ route('user.shop.accessories') }}?q=' + encodeURIComponent(searchQuery.trim())
                                            }
                                        "
                                                class="w-full pl-12 pr-4 py-3 rounded-2xl
                                               bg-white/60 dark:bg-white/5
                                               border border-white/30 dark:border-white/10
                                               text-gray-800 dark:text-gray-100
                                               placeholder:text-gray-500 dark:placeholder:text-gray-400
                                               focus:outline-none focus:ring-2 focus:ring-amber-400/50"
                                                x-ref="searchInput" x-init="$watch('openSearch', v => { if (v) setTimeout(() => $refs.searchInput?.focus(), 50) })" />
                                        </div>

                                        {{-- ✅ CHỈ NÚT NÀY MỚI ĐÓNG --}}
                                        <button type="button" @click="openSearch=false"
                                            class="px-4 py-3 rounded-2xl
                                           bg-white/60 dark:bg-white/5
                                           border border-white/30 dark:border-white/10
                                           text-gray-700 dark:text-gray-200
                                           hover:bg-white/80 dark:hover:bg-white/10 transition">
                                            <span data-vi="Đóng" data-en="Close"></span>
                                        </button>
                                    </div>
                                </div>

                                {{-- Grid links (GIỮ NGUYÊN link của bạn ở đây) --}}
                                <div class="p-4 sm:p-6">
                                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">

                                        <a href="{{ route('about') }}"
                                            class="group rounded-2xl p-4 bg-white/50 dark:bg-white/5 border border-white/25 dark:border-white/10
                                          hover:bg-white/70 dark:hover:bg-white/10 transition">
                                            <div class="flex items-center gap-3">
                                                <i data-lucide="info" class="w-5 h-5 text-amber-400"></i>
                                                <div>
                                                    <div class="font-semibold text-gray-800 dark:text-gray-100">
                                                        <span data-vi="Giới thiệu" data-en="About"></span>
                                                    </div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                                        <span data-vi="Về chúng tôi" data-en="About us"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>

                                        <a href="{{ route('user.menu.index') }}"
                                            class="group rounded-2xl p-4 bg-white/50 dark:bg-white/5 border border-white/25 dark:border-white/10
                                          hover:bg-white/70 dark:hover:bg-white/10 transition">
                                            <div class="flex items-center gap-3">
                                                <i data-lucide="utensils" class="w-5 h-5 text-amber-400"></i>
                                                <div>
                                                    <div class="font-semibold text-gray-800 dark:text-gray-100">Menu
                                                    </div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                                        <span data-vi="Thực đơn" data-en="Menu"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>

                                        <a href="{{ route('user.shop.accessories') }}"
                                            class="group rounded-2xl p-4 bg-white/50 dark:bg-white/5 border border-white/25 dark:border-white/10
                                          hover:bg-white/70 dark:hover:bg-white/10 transition">
                                            <div class="flex items-center gap-3">
                                                <i data-lucide="sparkles" class="w-5 h-5 text-amber-400"></i>
                                                <div>
                                                    <div class="font-semibold text-gray-800 dark:text-gray-100">
                                                        <span data-vi="Phụ kiện" data-en="Accessories"></span>
                                                    </div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                                        <span data-vi="Cửa hàng phụ kiện"
                                                            data-en="Accessories shop"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>

                                        <a href="{{ route('user.shop.rental') }}"
                                            class="group rounded-2xl p-4 bg-white/50 dark:bg-white/5 border border-white/25 dark:border-white/10
                                          hover:bg-white/70 dark:hover:bg-white/10 transition">
                                            <div class="flex items-center gap-3">
                                                <i data-lucide="shirt" class="w-5 h-5 text-amber-400"></i>
                                                <div>
                                                    <div class="font-semibold text-gray-800 dark:text-gray-100">
                                                        <span data-vi="Thuê đồ" data-en="Cosplay rental"></span>
                                                    </div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                                        <span data-vi="Thuê đồ cosplay"
                                                            data-en="Cosplay rental"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>

                                        <a href="{{ route('user.booking.tarot') }}"
                                            class="group rounded-2xl p-4 bg-white/50 dark:bg-white/5 border border-white/25 dark:border-white/10
                                          hover:bg-white/70 dark:hover:bg-white/10 transition">
                                            <div class="flex items-center gap-3">
                                                <i data-lucide="stars" class="w-5 h-5 text-amber-400"></i>
                                                <div>
                                                    <div class="font-semibold text-gray-800 dark:text-gray-100">
                                                        <span data-vi="Xem tarot" data-en="Tarot reading"></span>
                                                    </div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                                        <span data-vi="Đặt lịch xem tarot"
                                                            data-en="Book a tarot reading"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>

                                        <a href="{{ route('user.workshops.index') }}"
                                            class="group rounded-2xl p-4 bg-white/50 dark:bg-white/5 border border-white/25 dark:border-white/10
                                          hover:bg-white/70 dark:hover:bg-white/10 transition">
                                            <div class="flex items-center gap-3">
                                                <i data-lucide="flask-conical" class="w-5 h-5 text-amber-400"></i>
                                                <div>
                                                    <div class="font-semibold text-gray-800 dark:text-gray-100">
                                                        <span data-vi="Workshop" data-en="Workshop"></span>
                                                    </div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                                        <span data-vi="workshop" data-en="workshop"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>

                                        <a href="{{ route('user.news.index') }}"
                                            class="group rounded-2xl p-4 bg-white/50 dark:bg-white/5 border border-white/25 dark:border-white/10
                                          hover:bg-white/70 dark:hover:bg-white/10 transition">
                                            <div class="flex items-center gap-3">
                                                <i data-lucide="newspaper" class="w-5 h-5 text-amber-400"></i>
                                                <div>
                                                    <div class="font-semibold text-gray-800 dark:text-gray-100">
                                                        <span data-vi="Tin tức" data-en="News"></span>
                                                    </div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                                        <span data-vi="Cập nhật tin tức" data-en="Latest news"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>

                                        <a href="{{ route('user.contact.create') }}"
                                            class="group rounded-2xl p-4 bg-white/50 dark:bg-white/5 border border-white/25 dark:border-white/10
                                          hover:bg-white/70 dark:hover:bg-white/10 transition">
                                            <div class="flex items-center gap-3">
                                                <i data-lucide="phone" class="w-5 h-5 text-amber-400"></i>
                                                <div>
                                                    <div class="font-semibold text-gray-800 dark:text-gray-100">
                                                        <span data-vi="Liên hệ" data-en="Contact"></span>
                                                    </div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                                        <span data-vi="Liên hệ với chúng tôi"
                                                            data-en="Get in touch"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </template>
        @endif
    </nav>

    <style>
        .hp-navlink {
            @apply text-gray-800 dark:text-gray-100 hover:text-amber-400 transition-colors duration-300 relative after:absolute after:-bottom-1 after:left-0 after:w-0 after:h-[2px] after:bg-amber-400 after:transition-all after:duration-300 hover:after:w-full;
        }
    </style>
