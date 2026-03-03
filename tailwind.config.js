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

      // ✅ Tu color (NO lo cambio). Solo lo ordeno para que tenga sentido.
      colors: {
        brand: {
          50:  "#d42525",
          100: "#dcfce7",
          200: "#bbf7d0",
          300: "#86efac",
          400: "#4ade80",
          500: "#22c55e", // principal
          600: "#c11c1c",
          700: "#c22828",
          800: "#c72727",
          900: "#c82727",
        },
      },

      // ✅ Bordes más pro
      borderRadius: {
        xl: "0.9rem",
        "2xl": "1.25rem",
        "3xl": "1.75rem",
      },

      // ✅ Sombras más bonitas (para cards/login)
      boxShadow: {
        soft: "0 6px 20px rgba(0,0,0,0.06)",
        card: "0 12px 40px rgba(0,0,0,0.12)",
        glow: "0 0 0 4px rgba(34,197,94,0.18)", // alrededor de inputs/botones
      },

      // ✅ Animaciones suaves
      transitionTimingFunction: {
        smooth: "cubic-bezier(.2,.8,.2,1)",
      },

      // ✅ Un poco más de escala/espaciado para UI
      spacing: {
        18: "4.5rem",
        22: "5.5rem",
      },
    },
  },

  plugins: [forms, typography],
};