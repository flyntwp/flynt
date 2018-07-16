const gulp = require('gulp')

module.exports = function (config) {
  // 4) Update asset references in HTML
  gulp.task('revStaticFiles', function () {
    const path = require('path')
    const revReplace = require('gulp-rev-replace')
    var manifest = gulp.src(path.join(config.dest, '/rev-manifest.json'))
    return gulp.src(config.rev.srcStatic)
    .pipe(revReplace({
      manifest: manifest,
      replaceInExtensions: config.rev.staticFileExtensions
    }))
    .pipe(gulp.dest(path.join(config.dest)))
  })
}
