@php
@endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col items-center justify-center text-center space-y-4 py-10 max-w-7xl mx-auto
           bg-white/80 dark:bg-gray-800/80 rounded-2xl backdrop-blur-lg
           transition-all duration-500 ease-out"
            x-data="headerData()" x-init="init()">
            <div>
                <h2 class="font-semibold text-3xl md:text-4xl text-gray-900 dark:text-gray-100 leading-tight">
                    <span x-text="greeting"></span>,
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-500 to-indigo-400">
                        {{ Auth::user()->name }}
                    </span>
                    <span x-text="greetingEmoji"></span>
                </h2>

                <div class="flex items-center justify-center space-x-3 mt-2">
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                        <span class="text-sm text-green-600 dark:text-green-400 font-medium">Online</span>
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">•</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400" x-text="currentTime"></div>
                </div>
            </div>

            <p class="text-gray-600 dark:text-gray-300 text-lg font-medium">
                Here’s what’s happening with your business today.
            </p>
        </div>
    </x-slot>

    <!-- Floating Quick Actions -->
    <div class="fixed bottom-6 right-6 z-50" x-data="{ quickMenuOpen: false }">
        <div x-cloak x-show="quickMenuOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90"
            class="absolute bottom-16 right-0 bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 p-4 backdrop-blur-lg w-64">
            <div class="space-y-2">
                <a href="{{ route('admin.product.create') }}"
                    class="flex items-center space-x-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-xl transition-all duration-200 group">
                    <div
                        class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Add Product</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">⌘N</div>
                    </div>
                </a>
                <a href="{{ route('admin.news.create') }}"
                    class="flex items-center space-x-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-xl transition-all duration-200 group">
                    <div
                        class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Add news</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">⌘A</div>
                    </div>
                </a>
                <a href="{{ route('admin.workshop.create') }}"
                    class="flex items-center space-x-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-xl transition-all duration-200 group">
                    <div
                        class="w-10 h-10 bg-purple-100 dark:bg-purple-900 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Add workshop</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">⌘W</div>
                    </div>
                </a>
            </div>
        </div>

        <button @click="quickMenuOpen = !quickMenuOpen"
            class="w-14 h-14 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl shadow-2xl flex items-center justify-center text-white hover:scale-110 transition-all duration-300 hover:shadow-3xl animate-float">
            <svg x-cloak x-show="!quickMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            <svg x-cloak x-show="quickMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Background with gradient - Performance optimized -->
    <div
        class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-blue-50 dark:from-gray-900 dark:via-gray-800 dark:to-blue-900 gpu-accelerated critical-fold overflow-y-auto">
        <div class="py-8 min-h-full">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                <!-- Stats Overview -->
                <div class="mb-12">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Analytics Overview</h3>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">Real-time business metrics</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-green-400 rounded-full animate-ping"></div>
                                <span class="text-sm text-green-600 dark:text-green-400 font-medium">Live Data</span>
                            </div>
                            <button onclick="window.scrollTo({top: document.body.scrollHeight, behavior: 'smooth'})"
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center space-x-1">
                                <span>View All</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <livewire:dashboard.metrics />
                </div>

                <!-- Quick Actions -->
                <div class="mb-16">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Quick Actions</h3>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">Manage your business operations
                                efficiently</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($modules as $index => $module)
                            <div x-data="{ loading: false, hovered: false }"
                                class="group bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm hover:shadow-2xl border border-gray-100 dark:border-gray-700
                   transition-all duration-500 hover:-translate-y-2 hover:scale-105
                   flex flex-col justify-between h-full min-h-[260px]   <!-- ✅ thêm -->
                   @if ($module['color'] === 'sky')
hover:border-sky-200 dark:hover:border-sky-700
@elseif($module['color'] === 'green')
hover:border-green-200 dark:hover:border-green-700
@elseif($module['color'] === 'violet')
hover:border-violet-200 dark:hover:border-violet-700
@elseif($module['color'] === 'orange')
hover:border-orange-200 dark:hover:border-orange-700
@elseif($module['color'] === 'indigo')
hover:border-indigo-200 dark:hover:border-indigo-700
@elseif($module['color'] === 'amber')
hover:border-amber-200 dark:hover:border-amber-700
@elseif($module['color'] === 'teal')
hover:border-teal-200 dark:hover:border-teal-700
@elseif($module['color'] === 'rose')
hover:border-rose-200 dark:hover:border-rose-700
@elseif($module['color'] === 'cyan')
hover:border-cyan-200 dark:hover:border-cyan-700
@elseif($module['color'] === 'yellow')
hover:border-yellow-200 dark:hover:border-yellow-700
@elseif($module['color'] === 'pink')
hover:border-pink-200 dark:hover:border-pink-700
@elseif($module['color'] === 'fuchsia')
hover:border-fuchsia-200 dark:hover:border-fuchsia-700
@else
hover:border-gray-200 dark:hover:border-gray-700
@endif"
                                style="animation-delay: {{ $index * 100 }}ms" @mouseenter="hovered = true"
                                @mouseleave="hovered = false">

                                <a href="{{ $module['route'] === '#' ? '#' : route($module['route']) }}"
                                    @click="if('{{ $module['route'] }}' !== '#') { loading = true; setTimeout(() => loading = false, 2000); }"
                                    class="flex flex-col h-full">

                                    <!-- Header -->
                                    <div class="flex items-start justify-between mb-6">
                                        <div
                                            class="w-16 h-16 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg
                        @if ($module['color'] === 'sky') bg-gradient-to-br from-sky-400 to-sky-600 text-white
                        @elseif($module['color'] === 'green') bg-gradient-to-br from-green-400 to-green-600 text-white
                        @elseif($module['color'] === 'violet') bg-gradient-to-br from-violet-400 to-violet-600 text-white
                        @elseif($module['color'] === 'orange') bg-gradient-to-br from-orange-400 to-orange-600 text-white
                        @elseif($module['color'] === 'indigo') bg-gradient-to-br from-indigo-400 to-indigo-600 text-white
                        @elseif($module['color'] === 'amber') bg-gradient-to-br from-amber-400 to-amber-600 text-white
                        @elseif($module['color'] === 'teal') bg-gradient-to-br from-teal-400 to-teal-600 text-white
                        @elseif($module['color'] === 'rose') bg-gradient-to-br from-rose-400 to-rose-600 text-white
                        @elseif($module['color'] === 'cyan') bg-gradient-to-br from-cyan-400 to-cyan-600 text-white
                        @elseif($module['color'] === 'yellow') bg-gradient-to-br from-yellow-400 to-yellow-600 text-white
                        @elseif($module['color'] === 'pink') bg-gradient-to-br from-pink-400 to-pink-600 text-white
                        @elseif($module['color'] === 'fuchsia') bg-gradient-to-br from-fuchsia-400 to-fuchsia-600 text-white
                        @else bg-gradient-to-br from-gray-400 to-gray-600 text-white @endif">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="{{ $module['icon'] }}" />
                                            </svg>
                                        </div>
                                        <div
                                            class="opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-0 translate-x-2">
                                            <div class="flex items-center space-x-1 text-blue-600 dark:text-blue-400">
                                                <span class="text-sm font-medium">Open</span>
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Content -->
                                    <div class="flex flex-col flex-1 justify-between">
                                        <div class="space-y-3">
                                            <h3
                                                class="text-xl font-bold text-gray-900 dark:text-gray-100 transition-colors duration-300 group-hover:text-blue-600 dark:group-hover:text-blue-400">
                                                {{ $module['name'] }}
                                            </h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                                                {{ $module['desc'] }}
                                            </p>
                                        </div>

                                        <!-- Module Stats -->
                                        <div x-data="{ value: 0, target: {{ $module['stats'] }}, percent: {{ $module['progress'] ?? 75 }} }"
                                            x-intersect.once="let i = setInterval(() => {
         if (value < target) value += Math.ceil(target / 30);
         else { value = target; clearInterval(i); }
     }, 30)"
                                            class="pt-4 mt-auto border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">

                                            <!-- Donut Chart -->
                                            <div class="relative w-10 h-10">
                                                <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                                    <circle cx="18" cy="18" r="16" stroke="#e5e7eb"
                                                        stroke-width="3.5" fill="none" />
                                                    <circle cx="18" cy="18" r="16"
                                                        :stroke-dasharray="`${percent},100`" stroke-linecap="round"
                                                        stroke-width="3.5" fill="none"
                                                        class="@if ($module['color'] === 'blue') stroke-blue-500
                           @elseif($module['color'] === 'green') stroke-green-500
                           @elseif($module['color'] === 'orange') stroke-orange-500
                           @elseif($module['color'] === 'purple') stroke-purple-500
                           @elseif($module['color'] === 'sky') stroke-sky-500
                            @elseif($module['color'] === 'teal') stroke-teal-500
                            @elseif($module['color'] === 'violet') stroke-violet-500
                            @elseif($module['color'] === 'indigo') stroke-indigo-500
                            @elseif($module['color'] === 'amber') stroke-amber-500
                            @elseif($module['color'] === 'rose') stroke-rose-500
                            @elseif($module['color'] === 'cyan') stroke-cyan-500
                            @elseif($module['color'] === 'yellow') stroke-yellow-500
                            @elseif($module['color'] === 'green') stroke-green-500
                           @else stroke-gray-500 @endif
                           transition-all duration-700 ease-out" />
                                                </svg>
                                                <div class="absolute inset-0 flex items-center justify-center">
                                                    <span x-text="`${Math.round(percent)}%`"
                                                        class="text-[10px] font-bold text-gray-700 dark:text-gray-200"></span>
                                                </div>
                                            </div>

                                            <!-- Animated Counter -->
                                            <div x-data="{ value: 0, target: {{ $module['stats'] }} }" x-init="let start = 0;
                                            let duration = 1200;
                                            let startTime = null;
                                            
                                            function animateCounter(timestamp) {
                                                if (!startTime) startTime = timestamp;
                                                const progress = Math.min((timestamp - startTime) / duration, 1);
                                                value = Math.floor(progress * target);
                                                if (progress < 1) requestAnimationFrame(animateCounter);
                                            }
                                            requestAnimationFrame(animateCounter);">
                                                <span
                                                    class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                    Total
                                                </span>
                                                <span x-text="value"
                                                    class="text-sm font-bold text-gray-900 dark:text-gray-100 transition-all duration-300"></span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                <livewire:dashboard.interactive-charts />

                <!-- Performance Monitor -->
                <livewire:dashboard.mini-charts />

                <!-- Recent Activities -->
                <livewire:dashboard.recent-activity />

                <!-- Enhanced Footer -->
                <livewire:dashboard.footer-summary />
            </div>
        </div>
    </div>

    <script>
        // Initialize dark mode IMMEDIATELY to prevent flash
        if (!window.darkModeInitialized) {
            window.darkModeInitialized = true;
            const savedMode = localStorage.getItem('darkMode');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const isDark = savedMode !== null ? savedMode === 'true' : prefersDark;

            if (isDark) {
                document.documentElement.classList.add('dark');
                document.body.style.backgroundColor = '#111827';
            } else {
                document.documentElement.classList.remove('dark');
                document.body.style.backgroundColor = '#ffffff';
            }
        }

        // Header data with real-time updates
        function headerData() {
            return {
                currentTime: '',
                greeting: 'Good morning',
                greetingEmoji: '☀️',

                init() {
                    this.updateTime();
                    this.updateGreeting();
                    setInterval(() => {
                        this.updateTime();
                    }, 1000);

                    // Initialize keyboard shortcuts
                    this.initKeyboardShortcuts();
                },

                updateTime() {
                    const now = new Date();
                    this.currentTime = now.toLocaleTimeString('en-US', {
                        hour12: true,
                        hour: 'numeric',
                        minute: '2-digit'
                    });
                },

                updateGreeting() {
                    const hour = new Date().getHours();
                    if (hour < 12) {
                        this.greeting = 'Good morning';
                        this.greetingEmoji = '☀️';
                    } else if (hour < 17) {
                        this.greeting = 'Good afternoon';
                        this.greetingEmoji = '🌤️';
                    } else {
                        this.greeting = 'Good evening';
                        this.greetingEmoji = '🌙';
                    }
                },

                initKeyboardShortcuts() {
                    document.addEventListener('keydown', (e) => {
                        // Cmd/Ctrl + K for search
                        if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                            e.preventDefault();
                            const searchInput = document.querySelector('input[placeholder*="Search"]');
                            if (searchInput) searchInput.focus();
                        }
                        // Cmd/Ctrl + N for new product
                        if ((e.metaKey || e.ctrlKey) && e.key === 'n') {
                            e.preventDefault();
                            window.location.href = '{{ route('admin.product.create') }}';
                        }
                    });
                }
            }
        }

        // Initialize smooth scroll behavior
        document.addEventListener('DOMContentLoaded', function() {
            // Add smooth scrolling to all anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Add loading states to buttons
            document.querySelectorAll('button, a').forEach(element => {
                element.addEventListener('click', function() {
                    if (!this.classList.contains('no-loading')) {
                        this.style.transform = 'scale(0.95)';
                        setTimeout(() => {
                            this.style.transform = '';
                        }, 150);
                    }
                });
            });

            // Progressive loading animation
            const animatedElements = document.querySelectorAll('[style*="animation-delay"]');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animation = 'fadeInUp 0.6s ease-out forwards';
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });

            animatedElements.forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                observer.observe(el);
            });
        });

        // Add CSS animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeInUp {
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            .animate-float {
                animation: float 3s ease-in-out infinite;
            }
            
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
            }

            .backdrop-blur-lg {
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
            }

            .animate-pulse-slow {
                animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
            }

            @keyframes shimmer {
                0% { background-position: -200% 0; }
                100% { background-position: 200% 0; }
            }

            .animate-shimmer {
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
                background-size: 200% 100%;
                animation: shimmer 2s ease-in-out infinite;
            }

            .hover\\:shadow-3xl:hover {
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            }

            @keyframes slideInFromRight {
                0% {
                    transform: translateX(100%);
                    opacity: 0;
                }
                100% {
                    transform: translateX(0);
                    opacity: 1;
                }
            }

            .animate-slide-in-right {
                animation: slideInFromRight 0.5s ease-out;
            }

            @keyframes bounceIn {
                0%, 20%, 40%, 60%, 80% {
                    transform: translateY(0);
                    animation-timing-function: cubic-bezier(0.215, 0.610, 0.355, 1.000);
                }
                40% {
                    transform: translateY(-30px);
                    animation-timing-function: cubic-bezier(0.755, 0.050, 0.855, 0.060);
                }
                60% {
                    transform: translateY(-15px);
                    animation-timing-function: cubic-bezier(0.755, 0.050, 0.855, 0.060);
                }
                80% {
                    transform: translateY(-4px);
                    animation-timing-function: cubic-bezier(0.215, 0.610, 0.355, 1.000);
                }
            }

            .animate-bounce-in {
                animation: bounceIn 1s ease-out;
            }

            .glass-effect {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            .dark .glass-effect {
                background: rgba(0, 0, 0, 0.1);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }

            @keyframes glow {
                0%, 100% { box-shadow: 0 0 20px rgba(0, 0, 0, 0.5); }
                50% { box-shadow: 0 0 40px rgba(0, 0, 0, 0.8); }
            }

            .animate-glow {
                animation: glow 2s ease-in-out infinite;
            }

            @keyframes float3d {
                0%, 100% { 
                    transform: translateY(0px) rotateX(0deg);
                    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
                }
                50% { 
                    transform: translateY(-10px) rotateX(2deg);
                    box-shadow: 0 20px 60px rgba(0,0,0,0.15);
                }
            }

            .animate-float3d {
                animation: float3d 6s ease-in-out infinite;
            }

            .backdrop-saturate-150 {
                backdrop-filter: saturate(150%) blur(20px);
                -webkit-backdrop-filter: saturate(150%) blur(20px);
            }

            .gradient-border {
                background: linear-gradient(45deg, #3B82F6, #8B5CF6, #EC4899, #10B981);
                background-size: 400% 400%;
                animation: gradientShift 4s ease infinite;
            }

            @keyframes gradientShift {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }

            .neumorphism {
                background: #e0e0e0;
                box-shadow: 20px 20px 60px #bebebe, -20px -20px 60px #ffffff;
            }

            .dark .neumorphism {
                background: #2d3748;
                box-shadow: 20px 20px 60px #1a202c, -20px -20px 60px #4a5568;
            }
        `;
        document.head.appendChild(style);
    </script>
    <!-- Scroll Progress Indicator -->
    <div class="fixed top-0 left-0 w-full h-1 bg-gray-200 dark:bg-gray-700 z-50" x-data="scrollProgress()"
        x-init="init()">
        <div class="h-full bg-gradient-to-r from-blue-500 to-purple-600 transition-all duration-300"
            :style="`width: ${progress}%`"></div>
    </div>

    <!-- Navigation Controls -->
    <div class="fixed bottom-8 left-8 z-50 flex flex-col space-y-3" x-data="{ showControls: false }"
        @scroll.window="showControls = (window.pageYOffset > 200)">
        <!-- Back to Top -->
        <button x-cloak x-show="showControls" @click="window.scrollTo({top: 0, behavior: 'smooth'})"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90 translate-y-4"
            x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90"
            class="bg-blue-500 hover:bg-blue-600 text-white p-3 rounded-full shadow-lg transition-all duration-300 hover:scale-110"
            title="Back to top">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18">
                </path>
            </svg>
        </button>

        <!-- Scroll to Bottom -->
        <button x-cloak x-show="showControls" @click="window.scrollTo({top: document.body.scrollHeight, behavior: 'smooth'})"
            x-transition:enter="transition ease-out duration-300 delay-100"
            x-transition:enter-start="opacity-0 transform scale-90 translate-y-4"
            x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90"
            class="bg-green-500 hover:bg-green-600 text-white p-3 rounded-full shadow-lg transition-all duration-300 hover:scale-110"
            title="Scroll to bottom">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3">
                </path>
            </svg>
        </button>

        <!-- Debug Info Toggle -->
        <button x-cloak x-show="showControls"
            @click="console.log('🔍 Dashboard Debug:'); debugScroll(); alert('Check console for scroll debug info!');"
            x-transition:enter="transition ease-out duration-300 delay-200"
            x-transition:enter-start="opacity-0 transform scale-90 translate-y-4"
            x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90"
            class="bg-purple-500 hover:bg-purple-600 text-white p-3 rounded-full shadow-lg transition-all duration-300 hover:scale-110"
            title="Debug scroll info">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </button>
    </div>

    <script>
        // Add smooth scrolling to html
        document.documentElement.style.scrollBehavior = 'smooth';

        // Scroll progress tracker
        function scrollProgress() {
            return {
                progress: 0,
                init() {
                    this.updateProgress();
                    window.addEventListener('scroll', () => this.updateProgress());
                },
                updateProgress() {
                    const scrollTop = window.pageYOffset;
                    const docHeight = document.body.offsetHeight - window.innerHeight;
                    this.progress = Math.max(0, Math.min(100, (scrollTop / docHeight) * 100));
                }
            }
        }

        // Debug scroll information
        function debugScroll() {
            const info = {
                documentHeight: document.documentElement.scrollHeight,
                viewportHeight: window.innerHeight,
                scrollTop: window.pageYOffset,
                canScroll: document.documentElement.scrollHeight > window.innerHeight,
                remainingScroll: document.documentElement.scrollHeight - window.innerHeight - window.pageYOffset
            };
            console.table(info);
            return info;
        }

        // Ensure all content is visible and scrollable
        document.addEventListener('DOMContentLoaded', function() {
            // Force content visibility
            const mainContent = document.querySelector('.min-h-screen');
            if (mainContent) {
                mainContent.style.minHeight = 'max-content';
                mainContent.style.height = 'auto';
            }

            // Debug information
            setTimeout(() => {
                const info = debugScroll();
                console.log('🎯 Dashboard loaded successfully!');
                console.log('📏 Total content height:', info.documentHeight + 'px');
                console.log('🖥️ Viewport height:', info.viewportHeight + 'px');
                console.log('📜 Scrollable:', info.canScroll ? 'YES - ' + (info.documentHeight - info
                    .viewportHeight) + 'px to scroll' : 'NO');

                // Show scroll hint if content is scrollable
                if (info.canScroll && info.documentHeight > info.viewportHeight + 100) {
                    console.log('💡 Content is scrollable! Dashboard has many features below.');
                }
            }, 1000);
        });

        // Global debug function
        window.debugScroll = debugScroll;
    </script>

</x-app-layout>
