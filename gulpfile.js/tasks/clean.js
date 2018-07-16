const gulp = require('gulp')

module.exports = function (config) {
  gulp.task('clean', function () {
    const del = require('del')
    return del([
      `${config.dest}/**`
    ])
  })
}
