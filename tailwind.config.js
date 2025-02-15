const animate = require("tailwindcss-animate")
const defaultTheme = require('tailwindcss/defaultTheme')

/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: ["class"],
  safelist: ["dark"],
  prefix: "",

  content: [
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
    "./storage/framework/views/*.php",
    "./resources/views/**/*.blade.php",
    "./resources/js/**/*.{ts,tsx,vue}",
  ],

  theme: {
    container: {
      center: true,
      padding: "2rem",
      screens: {
        "2xl": "1400px",
      },
    },
    extend: {
      fontFamily: {
        sans: ['Orbitron', ...defaultTheme.fontFamily.sans],
        orbitron: ['Orbitron', 'sans-serif'],
      },
      colors: {
        border: "hsl(var(--border))",
        input: "hsl(var(--input))",
        ring: "hsl(var(--ring))",
        background: {
          DEFAULT: '#111827', // bg-gray-900
          secondary: '#1F2937', // bg-gray-800
        },
        foreground: "hsl(var(--foreground))",
        primary: {
          DEFAULT: '#FACC15', // Neon Yellow (text-yellow-400)
          hover: '#FCD34D', // text-yellow-300
          foreground: '#111827', // text-black for button text
        },
        secondary: {
          DEFAULT: '#93C5FD', // Neon Blue (text-blue-300)
          foreground: '#F3F4F6', // text-gray-100
        },
        destructive: {
          DEFAULT: "hsl(var(--destructive))",
          foreground: "hsl(var(--destructive-foreground))",
        },
        muted: {
          DEFAULT: "hsl(var(--muted))",
          foreground: "hsl(var(--muted-foreground))",
        },
        accent: {
          primary: '#FACC15', // text-yellow-400
          secondary: '#93C5FD', // text-blue-300
          hover: '#FCD34D', // text-yellow-300
          DEFAULT: "hsl(var(--accent))",
          foreground: "hsl(var(--accent-foreground))",
        },
        popover: {
          DEFAULT: "hsl(var(--popover))",
          foreground: "hsl(var(--popover-foreground))",
        },
        card: {
          DEFAULT: "hsl(var(--card))",
          foreground: "hsl(var(--card-foreground))",
        },
        text: {
          DEFAULT: '#F3F4F6', // text-gray-100
          muted: '#6B7280', // text-gray-500
        },
      },
      borderRadius: {
        xl: "calc(var(--radius) + 4px)",
        lg: "var(--radius)",
        md: "calc(var(--radius) - 2px)",
        sm: "calc(var(--radius) - 4px)",
      },
      keyframes: {
        "accordion-down": {
          from: { height: 0 },
          to: { height: "var(--radix-accordion-content-height)" },
        },
        "accordion-up": {
          from: { height: "var(--radix-accordion-content-height)" },
          to: { height: 0 },
        },
        "collapsible-down": {
          from: { height: 0 },
          to: { height: 'var(--radix-collapsible-content-height)' },
        },
        "collapsible-up": {
          from: { height: 'var(--radix-collapsible-content-height)' },
          to: { height: 0 },
        },
        glitch: {
          '0%': {
            textShadow: '0.05em 0 0 #00fffc, -0.03em -0.04em 0 #fc00ff, 0.025em 0.04em 0 #fffc00'
          },
          '15%': {
            textShadow: '0.05em 0 0 #00fffc, -0.03em -0.04em 0 #fc00ff, 0.025em 0.04em 0 #fffc00'
          },
          '16%': {
            textShadow: '-0.05em -0.025em 0 #00fffc, 0.025em 0.035em 0 #fc00ff, -0.05em -0.05em 0 #fffc00'
          },
          '49%': {
            textShadow: '-0.05em -0.025em 0 #00fffc, 0.025em 0.035em 0 #fc00ff, -0.05em -0.05em 0 #fffc00'
          },
          '50%': {
            textShadow: '0.05em 0.035em 0 #00fffc, 0.03em 0 0 #fc00ff, 0 -0.04em 0 #fffc00'
          },
          '99%': {
            textShadow: '0.05em 0.035em 0 #00fffc, 0.03em 0 0 #fc00ff, 0 -0.04em 0 #fffc00'
          },
          '100%': {
            textShadow: '-0.05em 0 0 #00fffc, -0.025em -0.04em 0 #fc00ff, -0.04em -0.025em 0 #fffc00'
          }
        }
      },
      animation: {
        "accordion-down": "accordion-down 0.2s ease-out",
        "accordion-up": "accordion-up 0.2s ease-out",
        "collapsible-down": "collapsible-down 0.2s ease-in-out",
        "collapsible-up": "collapsible-up 0.2s ease-in-out",
        'glitch': 'glitch 1s linear infinite',
      },
      boxShadow: {
        'neon': '0 0 5px theme(colors.accent.primary), 0 0 20px theme(colors.accent.primary)',
        'neon-blue': '0 0 5px theme(colors.accent.secondary), 0 0 20px theme(colors.accent.secondary)',
        'neon-button': '0 0 5px theme(colors.primary.DEFAULT), 0 0 15px theme(colors.primary.DEFAULT)',
        'neon-active': '0 0 8px #00fffc, 0 0 25px #00fffc',
      },
    },
  },
  plugins: [animate, require('@tailwindcss/forms')],
}
