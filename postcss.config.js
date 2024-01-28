const tailwindcss = require("tailwindcss");
const autoprefixer = require("autoprefixer");
const cssnano = require("cssnano")

module.exports = {
  plugins: [
    tailwindcss,
    process.env.NODE_ENV === "production" ? autoprefixer : null,
    /*process.env.NODE_ENV === 'production' ? */cssnano({ preset: 'default' })/* : null,*/
  ]
};