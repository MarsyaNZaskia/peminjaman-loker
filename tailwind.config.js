/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class', // Ini wajib ada supaya tombol kita fungsi
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}