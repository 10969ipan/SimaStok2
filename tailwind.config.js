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
        primary: '#4F46E5', // Warna ungu modern (Indigo 600)
        secondary: '#64748B', // Warna abu-abu slate
        dark: '#1E293B', // Warna background sidebar
      }
    },
  },
  plugins: [],
}