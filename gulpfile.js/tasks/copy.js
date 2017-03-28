const gulp = require('gulp')
const changed = require('gulp-changed')
const browserSync = require('browser-sync')
const handleErrors = require('../utils/handleErrors')

module.exports = function (config) {
  gulp.task('copy', function () {
    return gulp.src(config.copy)
    .pipe(changed(config.dest))
    .pipe(gulp.dest(config.dest))
    .on('error', handleErrors)
    .pipe(browserSync.stream())
  })
}
