const mix = require('laravel-mix');
const execa = require('execa');

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

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .sass('resources/sass/app-guest.scss', 'public/css')
   .copy("node_modules/tinymce/themes", "public/js/themes")
   .copy("node_modules/tinymce/plugins", "public/js/plugins")
   .copy("node_modules/tinymce/skins", "public/js/skins")
    .then(() => {
        console.info("Generating routes using Ziggy...")
        execa('php', ['artisan', 'ziggy:generate'])
            .then(result => {
                console.info("Successfully generated routes using Ziggy.")
            })
            .catch(error => {
                console.info("Failed generating routes using Ziggy.")
            })
    })
