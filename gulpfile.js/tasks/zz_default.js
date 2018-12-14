const gulp = require('gulp')

module.exports = function (config) {
  gulp.task('default', gulp.series(
    function (done) {
      global.watchMode = true
      done()
    },
    'clean',
    gulp.parallel(['copy', 'stylus']),
    'watch'
  ))
}
