const gulp = require('gulp')

module.exports = function (config) {
  gulp.task('build', gulp.series(
    'clean',
    gulp.parallel(['copy', 'webpack:build', 'stylus', 'lint']),
    'rev'
  ))
}
