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

/**
 * Require ./webpack.config.js and make a bundler from it
 */
const webpackConfig = require('./webpack.config')
const bundler = webpack(webpackConfig)

const browserSync = require('browser-sync').create()

const crypto = require('crypto')
const fileHashes = []
bundler.plugin('done', function (bundles) {
  bundles.stats.forEach(function (stats, i) {
    fileHashes[i] = fileHashes[i] || {}
    checkAssets(stats, fileHashes[i])
  })
})

function checkAssets (stats, bundleHashes) {
  try {
    const changedFiles = Object.keys(stats.compilation.assets)
      .filter(name => {
        const asset = stats.compilation.assets[name]
        const md5Hash = crypto.createHash('md5')
        const hash = md5Hash.update(asset.children ? asset.children[0]._value : asset.source()).digest('hex')
        if (bundleHashes[name] !== hash) {
          bundleHashes[name] = hash
          return true
        } else {
          return false
        }
      })
    browserSync.reload(changedFiles.map(name => `dist/${name}`))
  } catch (e) {}
}

browserSync.init(Object.assign({
  middleware: [
    webpackDevMiddleware(bundler, Object.assign({
      publicPath: webpackConfig[0].output.publicPath,
      logLevel: 'silent'
    }, config.webpackDevMiddleware))
  ]
}, config.browserSync))
