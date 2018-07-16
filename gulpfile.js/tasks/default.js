const gulp = require('gulp')

module.exports = function (config) {
  gulp.task('default', function (cb) {
    const runSequence = require('run-sequence')
    global.watchMode = true
    runSequence(
      'clean',
      ['copy', 'stylus'],
      ['watch'],
      cb
    )
  })
}
