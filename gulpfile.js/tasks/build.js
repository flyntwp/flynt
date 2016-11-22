const gulp = require('gulp')
const runSequence = require('run-sequence')

module.exports = function (config) {
  gulp.task('build', function (cb) {
    runSequence(
      'clean',
      ['copy', 'webpack:build'],
      'rev',
      cb
    )
  })
}
