const path = require('path')
const fs = require('fs')
const browserSync = require('browser-sync')
const gulp = require('gulp')
const gutil = require('gulp-util')
const webpack = require('webpack')

let previousAssets = []

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
    webpack(webpackConfig(config.webpack)).watch(null, webpackTask(callback))
  })
}
