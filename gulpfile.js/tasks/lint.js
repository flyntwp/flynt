const gulp = require('gulp')
const changed = require('gulp-changed')
const stylint = require('gulp-stylint')
const standard = require('gulp-standard')
const gutil = require('gulp-util')

module.exports = function(config) {
  gulp.task('lint', ['lint:stylus', 'lint:js'])

  gulp.task('lint:stylus', function () {
    return gulp.src(config.lint.stylus)
    .pipe(stylint())
    .pipe(stylint.reporter())
    .pipe(stylint.reporter('fail', { failOnWarning: true }))
  })

  gulp.task('lint:js', function () {
    return gulp.src(config.lint.js)
    .pipe(standard())
    .pipe(standard.reporter('default', {
      breakOnError: true,
      breakOnWarning: true,
      // quiet: true
    }))
  })
}
