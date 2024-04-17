/** @type {import('tailwindcss').Config} */
export default {
    content: ["./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                'chatgpt-light-gray': '#212121',
                'chatgpt-dark-gray': '#121212',
                'chatgpt-border-gray': '#333333',

            },
        },
    },
    plugins: [],
}