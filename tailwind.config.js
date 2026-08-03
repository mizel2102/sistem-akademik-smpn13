/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
    './resources/css/**/*.css'
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Plus Jakarta Sans', 'Inter', 'ui-sans-serif', 'system-ui'],
        display: ['Sora', 'Plus Jakarta Sans']
      },
      colors: {
        primary: '#0B63FF',
        secondary: '#10B981',
        accent: '#F97316',
        dark: '#0F172A',
        light: '#F9FAFB',
        border: '#E5E7EB',
        muted: '#6B7280'
      },
      spacing: {
        '28': '7rem',
        '72': '18rem'
      }
      ,
      fontSize: {
        'xs': ['0.75rem', { lineHeight: '1rem' }],
        'sm': ['0.875rem', { lineHeight: '1.25rem' }],
        'base': ['1rem', { lineHeight: '1.5rem' }],
        'lg': ['1.125rem', { lineHeight: '1.75rem' }],
        'xl': ['1.25rem', { lineHeight: '1.75rem' }],
      },
      lineHeight: {
        relaxed: '1.75'
      }
    }
  },
  plugins: []
}
