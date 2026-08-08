/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    '../app/views/**/*.php',
    '../public_html/**/*.php',
  ],
  theme: {
    extend: {
      colors: {
        brand: {
          orange: {
            50: '#FFF7ED',
            100: '#FFEDD5',
            200: '#FED7AA',
            300: '#FDBA74',
            400: '#FB9B3F',
            500: '#F5A623',
            600: '#F7931E',
            700: '#D9720F',
            800: '#B0590D',
            900: '#8F480F',
          },
          blue: {
            50: '#EEF3F9',
            100: '#D6E2F0',
            200: '#AEC5E1',
            300: '#7FA3CE',
            400: '#4C79AE',
            500: '#2A5A90',
            600: '#1B4F8C',
            700: '#164375',
            800: '#0D3B73',
            900: '#0A2C56',
            950: '#071E3B',
          },
          green: {
            50: '#F2FAEC',
            100: '#E1F3D3',
            200: '#C3E7A9',
            300: '#A0D879',
            400: '#87CB58',
            500: '#6CBE45',
            600: '#57A236',
            700: '#437D2A',
            800: '#365F24',
            900: '#2C4C20',
          },
          neutral: {
            50: '#FAF9F7',
            100: '#F3F1ED',
            200: '#E7E3DC',
            300: '#D4CDC1',
            400: '#AFA595',
            500: '#8C8072',
            600: '#6B6154',
            700: '#4F473D',
            800: '#332E28',
            900: '#211D19',
          },
        },
      },
      fontFamily: {
        display: ['Fraunces', 'ui-serif', 'Georgia', 'serif'],
        sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
      borderRadius: {
        xl: '1rem',
        '2xl': '1.5rem',
        '3xl': '2rem',
        '4xl': '2.5rem',
      },
      boxShadow: {
        soft: '0 4px 20px -4px rgba(13, 59, 115, 0.12)',
        'soft-lg': '0 20px 45px -12px rgba(13, 59, 115, 0.22)',
        glow: '0 0 0 6px rgba(245, 166, 35, 0.15)',
      },
      backgroundImage: {
        'brand-gradient': 'linear-gradient(135deg, #0D3B73 0%, #1B4F8C 55%, #164375 100%)',
        'sunrise-gradient': 'linear-gradient(135deg, #F5A623 0%, #F7931E 100%)',
      },
      animation: {
        'fade-up': 'fadeUp 0.7s ease-out forwards',
        'fade-in': 'fadeIn 0.6s ease-out forwards',
      },
      keyframes: {
        fadeUp: {
          '0%': { opacity: '0', transform: 'translateY(24px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
};
