import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    dark: '#080c35', // Deep dark blue background
                    primary: '#140c61', // The rich indigo/purple primary color
                    secondary: '#362293', // Lighter purple
                    accent: '#82d385', // Green accent used for tags
                    light: '#f7f8fc', // Very light grayish blue background
                    
                    // Dark mode specific colors (Dribbble inspired)
                    darkbg: '#0B0F19', // Main body bg in dark mode
                    darksurface: '#151A28', // Cards/Containers in dark mode
                    darkborder: '#23293B', // Subtle borders
                }
            }
        },
    },

    plugins: [forms],
};
