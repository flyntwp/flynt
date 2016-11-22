const gulp = require('gulp')
const runSequence = require('run-sequence')

module.exports = function (config) {
  gulp.task('default', function (cb) {
    global.watchMode = true
    runSequence(
      'clean',
      ['copy', 'stylus', 'lint'],
      ['watch'],
      cb
    )
  })
}
