const gulp = require('gulp')
const changed = require('gulp-changed')
const browserSync = require('browser-sync')
const plumber = require('gulp-plumber')
const notify = require('gulp-notify')

module.exports = function (config) {
  gulp.task('copy', function () {
    return gulp.src(config.copy)
    .pipe(plumber({errorHandler: notify.onError({
      title: 'Flynt Theme',
      subtitle: 'Build failed',
      message: 'Error:\n <%= error.message %>',
      sound: 'Beep'
    })}))
    .pipe(changed(config.dest))
    .pipe(plumber.stop())
    .pipe(gulp.dest(config.dest))
    .pipe(browserSync.stream())
  })
}
