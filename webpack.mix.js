const mix = require("laravel-mix");

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

mix.webpackConfig({
    resolve: {
        modules: [
            path.resolve("./resources/js"),
            path.resolve("./node_modules")
        ]
    }
    // output: {
    //    publicPath: '/',
    //    filename: mix.config.inProduction ? '[name].[chunkhash].js' : '[name].js',
    //    chunkFilename: mix.config.inProduction ? 'js/chunks/[name].[chunkhash].js' : 'js/chunks/[name].js',
    // },
    // module: {
    //    rules: [{
    //       test: /\.styl$/,
    //       loader: ['style-loader', 'css-loader', 'stylus-loader']
    //    }]
    // }
})
    .js("resources/js/app.js", "public/js")
    .sass("resources/sass/app.scss", "public/css");
