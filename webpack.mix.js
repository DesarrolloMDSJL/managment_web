const mix = require('laravel-mix');


mix
    .js('resources/assets/backend/js/app.js', 'public/backend/js/app.js').vue()
    .sass('resources/assets/backend/scss/app.scss','public/backend/css/app.css')
    .sourceMaps()
    .webpackConfig({
        devtool: 'source-map'
    })
    .options({
        processCssUrls: false
    });


mix.browserSync({
    proxy : 'http://localhost/notary_public_web/public/',
    open: true,
    files: [
        'app/**/*',
        'public/**/*',
        'resources/views/**/*',
        'resources/assets/**/*',
        'routes/**/*'
    ]
});