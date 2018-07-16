const gulp = require('gulp')

module.exports = function (config) {
  gulp.task('build', function (cb) {
    const runSequence = require('run-sequence')
    runSequence(
      'clean',
      ['copy', 'webpack:build', 'stylus', 'lint'],
      'rev',
      cb
    )
  })
}
