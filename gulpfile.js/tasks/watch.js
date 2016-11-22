const browserSync = require('browser-sync')
const gulp = require('gulp')
const watch = require('gulp-watch')

module.exports = function(config) {
  gulp.task('watch', ['webpack:watch', 'browserSync'], function (cb) {
    watch(config.copy, function() { gulp.start('copy')})//.on('change', browserSync.reload)
    watch(config.stylus, function() { gulp.start('stylus')})//.on('change', browserSync.reload)
    watch(config.php, function() { }).on('change', browserSync.reload)
    watch(config.lint.stylus, function() { gulp.start('lint:stylus')})
    watch(config.lint.js, function() { gulp.start('lint:js')})
  })
}
