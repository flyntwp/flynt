const gulp = require('gulp')

module.exports = function (config) {
  gulp.task('browserSync', function () {
    const browserSync = require('browser-sync')
    return browserSync.init(config.browserSync)
  })
}
