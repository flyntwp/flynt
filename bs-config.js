/*
 |--------------------------------------------------------------------------
 | Browser-sync config file
 |--------------------------------------------------------------------------
 |
 | For up-to-date information about the options:
 |   http://www.browsersync.io/docs/options/
 |
 | There are more options than you see here, these are just the ones that are
 | set internally. See the website for more info.
 |
 |
 */
const config = require('./build-config')

const webpack = require('webpack')
const webpackDevMiddleware = require('webpack-dev-middleware')
const webpackHotMiddleware = require('webpack-hot-middleware')

/**
 * Require ./webpack.config.js and make a bundler from it
 */
const webpackConfig = require('./webpack.config')
const bundler = webpack(webpackConfig)

module.exports = Object.assign({
  middleware: [
    webpackDevMiddleware(bundler, Object.assign({
      publicPath: webpackConfig.output.publicPath,
      logLevel: 'silent'
    }, config.webpackDevMiddleware)),
    webpackHotMiddleware(bundler, {
      log: false
    })
  ]
}, config.browserSync)
