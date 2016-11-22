const del = require('del')
const gulp = require('gulp')

module.exports = function (config) {
  gulp.task('clean', function () {
    return del([
      `${config.dest}/**`
    ])
  })
}
