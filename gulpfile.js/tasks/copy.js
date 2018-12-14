const gulp = require('gulp')

module.exports = function (config) {
  gulp.task('copy', function () {
    const changed = require('gulp-changed')
    // const handleErrors = require('../utils/handleErrors')
    let task = gulp.src(config.copy)
    .pipe(changed(config.dest))
    .pipe(gulp.dest(config.dest))
    // .on('error', handleErrors)
    if (global.watchMode) {
      const browserSync = require('browser-sync')
      task = task.pipe(browserSync.stream())
    }
    return task
  })
}
