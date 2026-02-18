import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    maroon: '#450706',
                    'maroon-dark': '#2b0303',
                    gold: '#d1b57a',
                    beige: '#e4cfa0',
                    red: '#b33939',
                    whatsapp: '#25d366',
                },
            },
        },
    },

    plugins: [forms],
};
