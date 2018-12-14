const gulp = require('gulp')

module.exports = function (config) {
  gulp.task('setWatchMode', function (done) {
    global.watchMode = true
    done()
  })
  gulp.task('default', gulp.series(
    'setWatchMode',
    'clean',
    gulp.parallel(['copy', 'stylus']),
    'watch'
  ))
}
