const browserSync = require('browser-sync')
const gulp = require('gulp')
const watch = require('gulp-watch')
const runSequence = require('run-sequence')

module.exports = function (config) {
  gulp.task('watch:files', function () {
    watch(config.copy, function () { gulp.start('copy') })
    watch(config.watch.stylus, function () { gulp.start('stylus') })
    watch(config.watch.php, function () { }).on('change', browserSync.reload)
    watch(config.lint.stylus, function () { gulp.start('lint:stylus') })
    watch(config.lint.js, function () { gulp.start('lint:js') })
    watch(config.lint.php, function () { gulp.start('lint:php') })
  })
  gulp.task('watch', function (cb) {
    runSequence(
      ['webpack:watch', 'browserSync'],
      'watch:files',
      cb
    )
  })
}
