const gulp = require('gulp')
const path = require('path')
const revReplace = require('gulp-rev-replace')

module.exports = function(config) {
  // 2) Update asset references with reved filenames in compiled css + js
  gulp.task('revUpdateReferences', function(){
    var manifest = gulp.src(path.join(config.dest, "rev-manifest.json"))

    return gulp.src(path.join(config.dest,'/**/**.{css,js}'))
    .pipe(revReplace({manifest: manifest}))
    .pipe(gulp.dest(config.dest))
  })
}
