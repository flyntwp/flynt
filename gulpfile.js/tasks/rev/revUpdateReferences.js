const gulp = require('gulp')

module.exports = function (config) {
  // 2) Update asset references with reved filenames in compiled css + js
  gulp.task('revUpdateReferences', function () {
    const path = require('path')
    const revReplace = require('gulp-rev-replace')
    var manifest = gulp.src(path.join(config.dest, 'rev-manifest.json'))

    return gulp.src(path.join(config.dest, '/**/**.{css,js}'))
    .pipe(revReplace({manifest: manifest}))
    .pipe(gulp.dest(config.dest))
  })
}
