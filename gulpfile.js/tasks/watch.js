const gulp = require('gulp')
const path = require('path')
const fs = require('fs')
let watch

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
        const del = require('del')
        return del(dirPath, {force: true})
      }
    }
  })
}

function watchWebpack (src) {
  watch(src)
  .on('data', function (file) {
    const webpackTask = require('./webpack')
    if (webpackTask.watching) {
      if (file.event === 'add' || file.event === 'unlink') {
        webpackTask.watching.invalidate()
      }
    }
  })
}

module.exports = function (config) {
  gulp.task('watch:files', function () {
    watch = require('gulp-watch')
    watchAndDelete(config.copy, function () { gulp.start('copy') }, config.dest)
    watchAndDelete(config.watch.stylus, function () { gulp.start('stylus') }, config.dest)
    watch(config.watch.php, function () { })
    watchWebpack(config.webpack.entry)
  })
  gulp.task('watch', function (cb) {
    const runSequence = require('run-sequence')
    runSequence(
      ['webpack:watch', 'browserSync'],
      'watch:files',
      cb
    )
  })
}
