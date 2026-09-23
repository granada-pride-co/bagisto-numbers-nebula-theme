/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./src/Resources/**/*.blade.php",
    "./src/Resources/**/*.js",
    "./src/Resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        cream: "#fbf8f1",
        paper: "#fffefd",
        ink: "#2e2224",
        line: "rgba(46, 34, 36, 0.15)",
        lineDark: "#2e2224",
        pink: {
          DEFAULT: "#f089a8",
          soft: "#f7b7ba",
          light: "#fdf0f4",
        },
        magenta: {
          DEFAULT: "#bd1765",
          deep: "#8f0e4b",
          dark: "#680a37",
        },
        mint: {
          DEFAULT: "#91e4d9",
          light: "#eafaf7",
        },
        lilac: {
          DEFAULT: "#d9c7ff",
          light: "#f5f0ff",
        },
        gold: {
          DEFAULT: "#c29958",
          light: "#d4af37",
          dark: "#a8803e",
        },
      },
      fontFamily: {
        serif: ["var(--font-serif)", "Cormorant Garamond", "Amiri", "El Messiri", "Georgia", "serif"],
        sans: ["var(--font-sans)", "DM Sans", "IBM Plex Sans Arabic", "Tajawal", "system-ui", "sans-serif"],
        mono: ["var(--font-mono)", "Courier Prime", "Courier New", "monospace"],
      },
      boxShadow: {
        luxury: "0 10px 30px -5px rgba(46, 34, 36, 0.08)",
        drawer: "-10px 0 35px rgba(46, 34, 36, 0.25)",
      },
    },
  },
  plugins: [],
};
