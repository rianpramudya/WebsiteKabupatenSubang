/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'yellow-subang': '#FCE405',
        'orange-subang': '#FF3B00',
        'red-subang': '#E20E0D',
        'blue-subang': '#1E4E7C',
      }
    }
  }, // <-- Kurung kurawal ini yang dipindahkan

  plugins: [],
}