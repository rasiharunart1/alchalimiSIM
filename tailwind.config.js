/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                // Custom Color berdasarkan Logo Al-Chalimi
                chalimi: {
                    50: '#ecfdf5',
                    100: '#d1fae5',
                    200: '#a7f3d0',
                    300: '#6ee7b7',
                    400: '#34d399',
                    500: '#10b981',
                    600: '#009b77', // PRIMARY - Warna Logo
                    700: '#047857',
                    800: '#065f46',
                    900: '#064e3b', // Dark Text
                },
                accent: {
                    500: '#F59E0B', // Gold/Amber untuk CTAs
                }
            },
            fontFamily: {
                sans: ['Inter', 'system-ui', 'sans-serif'],
                arabic: ['Amiri', 'serif'],
            },
            animation: {
                'fade-in-up': 'fadeInUp 0.6s ease-out forwards',
            },
            keyframes: {
                fadeInUp: {
                    '0%': { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                }
            }
        },
    },
    plugins: [],
}
