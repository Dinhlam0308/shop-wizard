    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Always Café') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@500;600&display=swap"
            rel="stylesheet">

        <livewire:styles />

        <script src="https://unpkg.com/lucide@latest"></script>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script defer src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Crimson+Text:wght@400;600&family=Inter:wght@300;400;500;600;700&display=swap"
            rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
            rel="stylesheet">

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script>
            (function() {
                const savedMode = localStorage.getItem('darkMode');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const isDark = savedMode !== null ? savedMode === 'true' : prefersDark;

                if (isDark) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            })();

            document.addEventListener("DOMContentLoaded", () => {
                window.lucide?.createIcons?.();
            });
        </script>
    </head>

    <body class="font-sans antialiased transition-all duration-1000 ease-in-out">

        @include('layouts.navigation')
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('components.magical-background')
            @isset($header)
                <header class="pt-24 pb-4">
                    {{ $header }}
                </header>
            @endisset

            <main>
                @php
                    $hasSessionSuccess = session()->has('success');
                    $hasSessionError = session()->has('error');
                    $hasValidationError = isset($errors) && $errors->any();
                @endphp

                @if ($hasSessionSuccess)
                    <x-toast type="success" :message="session('success')" />
                @endif

                @if ($hasSessionError)
                    <x-toast type="error" :message="session('error')" />
                @endif

                @if ($hasValidationError)
                    <x-toast type="error" :message="$errors->first()" />
                @endif
                        
                {{ $slot }}
            </main>
            <x-footer />
        </div>

        <livewire:scripts />

        <script>
            window.DarkMode = {
                get isDark() {
                    return document.documentElement.classList.contains('dark');
                },

                set isDark(value) {
                    if (value) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }

                    localStorage.setItem('darkMode', value.toString());

                    window.dispatchEvent(new CustomEvent('darkModeChanged', {
                        detail: {
                            isDark: value
                        }
                    }));
                },

                toggle() {
                    this.isDark = !this.isDark;
                },

                init() {
                    const savedMode = localStorage.getItem('darkMode');
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                    this.isDark = savedMode !== null ? savedMode === 'true' : prefersDark;

                    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                        if (localStorage.getItem('darkMode') === null) {
                            this.isDark = e.matches;
                        }
                    });
                }
            };

            document.addEventListener('DOMContentLoaded', () => {
                window.DarkMode.init();
            });
        </script>

        <script>
            const LANG_KEY = "lang"; // "vi" | "en"

            function getLang() {
                return localStorage.getItem(LANG_KEY) || "vi";
            }

            function setLang(lang) {
                localStorage.setItem(LANG_KEY, lang);
                applyLang();
                window.dispatchEvent(new CustomEvent("langChanged", {
                    detail: {
                        lang
                    }
                }));
            }

            function applyLang() {
                const lang = getLang();

                // đổi chữ trên toàn trang
                document.querySelectorAll("[data-vi][data-en]").forEach(el => {
                    el.textContent = el.dataset[lang];
                });
                document.querySelectorAll("[data-placeholder-vi][data-placeholder-en]").forEach(el => {
                    el.placeholder = el.dataset[`placeholder${lang.charAt(0).toUpperCase() + lang.slice(1)}`];
                });

                // cập nhật nút VI / EN
                const label = document.getElementById("langLabel");
                if (label) label.textContent = lang.toUpperCase();
            }

            // init khi load
            document.addEventListener("DOMContentLoaded", () => {
                applyLang();

                const btn = document.getElementById("langToggleBtn");
                if (btn) {
                    btn.addEventListener("click", () => {
                        const next = getLang() === "vi" ? "en" : "vi";
                        setLang(next);
                    });
                }
            });
        </script>

    </body>

    </html>
