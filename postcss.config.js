/** @type {import('postcss-load-config').Config} */
module.exports = {
    plugins: [
      require('autoprefixer'),
      require('postcss-nested'),
      require('postcss-import'),
      require('postcss-preset-env'),
    ]
  }
