const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

module.exports = {
    darkMode: 'media',
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    50: '#F4ECFC',
                    100: '#DBC9F0',
                    200: '#BCA1DC',
                    300: '#A58DC2',
                    400: '#927BAF',
                    500: '#80699D',
                    600: '#7B639A',
                    700: '#6E5192',
                    800: '#5E3B8A',
                    900: '#3B205B'
                },
                'litepie-primary': colors.lightBlue,
                'litepie-secondary': colors.coolGray
            }
        },

    },

    variants: {
        extend: {
            opacity: ['disabled'],
            backgroundColor: ['even', 'odd'],
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
