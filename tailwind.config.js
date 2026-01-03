import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    darkMode: 'class', // Enable class-based dark mode

    theme: {
        extend: {
            fontFamily: {
                sans: ['Montserrat', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: "#0071e3",   // Xanh Apple
                    dark: "#005bb5",      // Hover
                },
                secondary: "#f5f5f7",   // Background nhạt
                accent: "#34c759",      // Success
                warning: "#ff9f0a",     // Warning
                danger: "#ff3b30",      // Lỗi / Xóa
                text: {
                    main: "#1d1d1f",      // Chữ chính
                    muted: "#6e6e73",     // Chữ phụ
                },
                border: "#d2d2d7",      // Đường viền
                bg: {
                    light: "#ffffff",     // Card
                    dark: "#f5f5f7",      // Nền dashboard
                },
            }
        }
    },


plugins: [forms],
};
