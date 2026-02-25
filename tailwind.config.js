import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },

            // ✅ Color institucional (verde)
            colors: {
                brand: {
                    50:  "#f0fdf4",
                    100: "#dcfce7",
                    200: "#bbf7d0",
                    300: "#86efac",
                    400: "#4ade80",
                    500: "#22c55e", // principal
                    600: "#16a34a",
                    700: "#15803d",
                    800: "#166534",
                    900: "#14532d",
                },
            },

            // ✅ Bordes más bonitos
            borderRadius: {
                xl: "0.9rem",
                "2xl": "1.25rem",
            },

            // ✅ Sombra suave tipo portal
            boxShadow: {
                soft: "0 6px 20px rgba(0,0,0,0.06)",
            },
        },
    },

    plugins: [forms, typography],
};