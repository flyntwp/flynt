const browserSync = require('browser-sync')
const gulp = require('gulp')

module.exports = function (config) {
  gulp.task('browserSync', function () {
    return browserSync.init(config.browserSync)
  })
}
