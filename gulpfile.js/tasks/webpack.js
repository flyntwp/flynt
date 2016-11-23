const browserSync = require('browser-sync')
const globby = require('globby')
const gulp = require('gulp')
const gutil = require('gulp-util')
const webpack = require('webpack')

const webpackTask = function (callback) {
  var initialCompile = false
  return function (err, stats) {
    if (err) {
      throw new gutil.PluginError('webpack:build', err)
    }
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
  config.webpack.entry = globby.sync('{Modules,assets}/**/script.js').reduce(function (output, entryPath) {
    output[entryPath.replace('/script.js', '')] = './' + entryPath
    return output
  }, {})

  gulp.task('webpack:build', function (callback) {
    config.webpack.production = true
    webpack(webpackConfig(config.webpack), webpackTask(callback))
  })

  gulp.task('webpack:watch', function (callback) {
    webpack(webpackConfig(config.webpack)).watch(null, webpackTask(callback))
  })
}
