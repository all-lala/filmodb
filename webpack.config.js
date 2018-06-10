// webpack.config.js
var Encore = require('@symfony/webpack-encore');
const { VueLoaderPlugin } = require('vue-loader')

Encore
    // the project directory where all compiled assets will be stored
    .setOutputPath('web/build/')

    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    
    .addEntry('custom', './web/assets/js/custom.js')

    // allow legacy applications to use $/jQuery as a global variable
    .autoProvidejQuery()

    // enable source maps during development
    .enableSourceMaps(!Encore.isProduction())

    // empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()

    // show OS notifications when builds finish/fail
    .enableBuildNotifications()
    
    // enable VueJs
    .enableVueLoader()
    
    .addEntry('movieTable', './web/assets/vuejs/movieTable.js')
;

// export the final configuration
module.exports = Encore.getWebpackConfig();

module.exports.plugins.push(new VueLoaderPlugin());