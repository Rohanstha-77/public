/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./*.php", "./template-parts/*.php", "./**/*.js"],
  safelist: ["flex"],
  theme: {
    extend: {
      colors : {
        yellow : "#FFCC70",
        purple : "#C850C0",
        aqua : "#12DAFB",
        pink : "#FF4F8B",
        white : "#FFF19C"
      }
    },

  },
  plugins: [],
}