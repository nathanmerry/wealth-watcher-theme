module.exports = {
  // mode: 'jit',
  purge: {
    enabled: false,
    content: [
      './src/views/**/*.twig'
    ],
    options: {
      preserveHtmlElements: false,
      keyframes: true
    }
  },
  darkMode: false, // or 'media' or 'class'
  theme: {
    colors: {
      white: '#fff',
      primary: 'var(--primary-color)',
      'primary-darken': 'var(--primary-color-darken)', 
      secondary: 'var(--secondary-color)',
      red: {
        DEFAULT: '#ef4444',
        100: '#FEE2E2',
        500: '#ef4444',
        700: '#B91C1C'
      },
      orange: '#ffa700',
      orangeHover: '#E59500',
      blazeOrange: '#ff5d00',
      // orange: {
      //   default: '#ffa700',
      //   100: '#fffaf0',
      //   500: '#ed8936',
      //   700: '#c05621'
      // },
      green: {
        100: '#D1FAE5',
        500: '#10B981',
        700: '#047857'
      },
      inputBorderGrey: '#c6c6c6',
      borderPurple: '#848edc'
    },
    extend: {
      backgroundSize: {
        'full': '100%'
      },
      borderRadius: {
        'lg+': '0.625rem'
      },
      fontFamily: {
        body: 'var(--font-body)',
        heading: 'var(--font-heading)'
      },
      fontSize: {
        'base-': '0.9375rem',
        'base+': '1.0625rem',
        '1.5xl': '1.375rem',
        '2.5xl': '2rem',
        '4.5xl': '2.5rem',
        '5.5xl': '3.375rem',
        '6.5xl': '4rem'
      },
      maxWidth: {
        '8xl': '90rem'
      },
      spacing: {
        15: '3.75rem'
      },
      width: {
        18: '4.5rem'
      }
    },
  },
  variants: {
    extend: {
      fontWeight: ['hover']
    },
  },
  plugins: [],
}