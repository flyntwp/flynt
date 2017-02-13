const path = require('path')
const fs = require('fs')
const gulp = require('gulp')
const watch = require('gulp-watch')
const runSequence = require('run-sequence')
const webpackTask = require('./webpack')

const extensionMappings = {
  '.styl': '.css'
}

function watchAndDelete (src, callback, dest) {
  return watch(src, {
    events: ['add', 'change', 'unlink', 'unlinkDir']
  }, callback)
  .on('data', function (file) {
    if (file.event === 'unlink') {
      const filePath = path.join(dest, file.relative)
      if (fs.existsSync(filePath)) {
        fs.unlinkSync(filePath)
      }
      if (extensionMappings[file.extname]) {
        const relativeDest = path.dirname(filePath)
        const mappedFilePath = path.join(relativeDest, file.stem + extensionMappings[file.extname])
        if (fs.existsSync(mappedFilePath)) {
          fs.unlinkSync(mappedFilePath)
        }
      }
    }
    if (file.event === 'unlinkDir') {
      const dirPath = path.join(dest, file.relative)
      if (fs.existsSync(dirPath)) {
        fs.rmdirSync(dirPath)
      }
    }
  })
}

function watchWebpack (src) {
  watch(src, function () { console.log('watch', arguments) })
  .on('data', function (file) {
    if (webpackTask.watching) {
      if (file.event === 'add' || file.event === 'unlink') {
        webpackTask.watching.invalidate()
      }
    }
  })
}

module.exports = function (config) {
  gulp.task('watch:files', function () {
    watchAndDelete(config.copy, function () { gulp.start('copy') }, config.dest)
    watchAndDelete(config.watch.stylus, function () { gulp.start('stylus') }, config.dest)
    watch(config.watch.php, function () { })
    watch(config.lint.stylus, function () { gulp.start('lint:stylus') })
    watch(config.lint.js, function () { gulp.start('lint:js') })
    watch(config.lint.php, function () { gulp.start('lint:php') })
    watchWebpack(config.webpack.entry)
  })
  gulp.task('watch', function (cb) {
    runSequence(
      ['webpack:watch', 'browserSync'],
      'watch:files',
      cb
    )
  })
}
