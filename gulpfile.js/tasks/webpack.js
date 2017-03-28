const path = require('path')
const fs = require('fs')
const browserSync = require('browser-sync')
const gulp = require('gulp')
const gutil = require('gulp-util')
const webpack = require('webpack')
const handleErrors = require('../utils/handleErrors.js')

let previousAssets = []
let previousHash

function removeUnusedAssets (stats) {
  const basePath = path.join(
    stats.compilation.options.context,
    stats.compilation.outputOptions.path
  )
  const currentAssets = Object.keys(stats.compilation.assets)
  const unusedAssets = previousAssets.filter(function (asset) {
    return currentAssets.indexOf(asset) === -1
  })
  unusedAssets.forEach(function (asset) {
    const assetPath = path.join(basePath, asset)
    if (fs.existsSync(assetPath)) {
      fs.unlinkSync(assetPath)
    }
  })
  previousAssets = currentAssets
}

const webpackTask = function (callback) {
  var initialCompile = false
  return function (err, stats) {
    if (err) {
      throw new gutil.PluginError('webpack:build', err)
    }

    if (stats.compilation.errors.length > 0) {
      stats.compilation.errors.forEach(function (error) {
        error.plugin = 'Webpack'
        handleErrors(error)
      })
    }

    if (previousHash !== stats.hash) {
      previousHash = stats.hash
      removeUnusedAssets(stats)
      browserSync.reload()
      gutil.log('[webpack:build] Completed\n' + stats.toString({
        assets: true,
        chunks: false,
        chunkModules: false,
        colors: true,
        hash: false,
        timings: false,
        version: false
      }))
    }
    if (!initialCompile) {
      initialCompile = true
      callback()
    }
  }
}

module.exports = function (webpackConfig, config) {
  gulp.task('webpack:build', function (callback) {
    config.webpack.production = true
    webpack(webpackConfig(config.webpack), webpackTask(callback))
  })

  gulp.task('webpack:watch', function (callback) {
    module.exports.watching = webpack(webpackConfig(config.webpack)).watch(null, webpackTask(callback))
  })
}
