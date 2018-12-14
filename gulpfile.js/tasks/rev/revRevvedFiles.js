const gulp = require('gulp')

module.exports = function (config) {
  // 3) Rev and compress CSS and JS files (this is done after assets, so that if a
  //    referenced asset hash changes, the parent hash will change as well
  gulp.task('revRevvedFiles', function () {
    const rev = require('gulp-rev')
    const revNapkin = require('gulp-rev-napkin')
    return gulp.src(config.rev.srcRevved)
      .pipe(rev({
        replaceInExtensions: config.rev.revvedFileExtensions
      }))
      .pipe(gulp.dest(config.dest))
      .pipe(revNapkin({ verbose: false }))
      .pipe(rev.manifest({ merge: true }))
      .pipe(gulp.dest(config.dest))
  })
}
