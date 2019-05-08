let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
//
mix.sourceMaps(false)
  .js('src/main.js', 'public/js')
  .extract(['vue'])
  .sass('src/assets/scss/main.scss', 'public/css')
  .minify('public/css/main.css')
  .copy('static', 'public/static')
  .copy('src/assets/fonts', 'public/fonts')
  .options({
    processCssUrls: false,
    uglify: {
      parallel: 4,
      sourceMap: false,
      uglifyOptions: {
        compress: {
          // warnings: false,
          // drop_console: true,
        }
      }
    }
  });