const gulp = require('gulp')
const runSequence = require('run-sequence')

module.exports = function(config) {
  gulp.task('default', function (cb) {
    runSequence(
      'clean',
      ['copy', 'stylus'],
      ['watch'],
      cb
    )
  });
}
