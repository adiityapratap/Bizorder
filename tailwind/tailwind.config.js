/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "../application/views/**/*.{php,html,js,jsx,ts,tsx}",
    "../application/modules/**/*.{php,html,js,jsx,ts,tsx}",
    "../application/helpers/**/*.{php,html,js,jsx,ts,tsx}",
    "../application/controllers/**/*.{php,html,js,jsx,ts,tsx}"
],
  safelist: [
    {
      pattern: /^bg-(blue|green|purple|amber|red|indigo|teal|pink|primary)-500$/,
    },
    {
      pattern: /^hover:bg-(blue|green|purple|amber|red|indigo|teal|pink)-500$/,
    },
    {
      pattern: /^bg-brand-(blue|red|green|yellow|purple|indigo|teal|pink)$/,
    },
    {
      pattern: /^hover:bg-brand-(blue|red|green|yellow|purple|indigo|teal|pink)$/,
    },
    {
      pattern: /^text-(white|black)$/,
    },
    'rounded-lg',
    'shadow-md',
    'hover:bg-hover',
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', 'sans-serif'],
      },
      colors: {
        primary: {
          50: '#f0fdf4',
          100: '#dcfce7',
          200: '#bbf7d0',
          300: '#86efac',
          400: '#4ade80',
          500: '#22c55e',
          600: '#16a34a',
          700: '#15803d',
          800: '#166534',
          900: '#14532d',
        },
        secondary: {
          50: '#fff7ed',
          100: '#ffedd5',
          200: '#fed7aa',
          300: '#fdba74',
          400: '#fb923c',
          500: '#f97316',
          600: '#ea580c',
          700: '#c2410c',
          800: '#9a3412',
          900: '#7c2d12',
        },
        danger: {
          500: '#ef4444',
          600: '#dc2626',
        },
        brand: {
          blue: '#1a365d',
          red: '#dc2626',
          green: '#059669',
          yellow: '#facc15',
          purple: '#8b5cf6',
          indigo: '#6366f1',
          teal: '#14b8a6',
          pink: '#ec4899',
        },
        chef:{
        green: '#38A169',
        blue: '#162945',
        purple: '#805AD5',
        orange: '#ED8936',
        red: '#E53E3E',  
        },
        sidebar: '#F7F9FB',
        header: '#1E3A8A',
        link: '#2563EB',
        confirm: '#10B981',
        border: '#D1D5DB',
        hover: '#E0F2FE',
      },
    },
  },
  plugins: [],
}
