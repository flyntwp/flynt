const gulp = require('gulp')

module.exports = function (config) {
  // 1) Add md5 hashes to assets referenced by CSS and JS files
  gulp.task('revAssets', function () {
    const path = require('path')
    const rev = require('gulp-rev')
    const revNapkin = require('gulp-rev-napkin')
    // Ignore files that may reference assets. We'll rev them next.
    return gulp.src(config.rev.assetSrc)
      .pipe(rev())
      .pipe(gulp.dest(config.dest))
      .pipe(revNapkin({ verbose: false }))
      .pipe(rev.manifest(path.join(config.dest, 'rev-manifest.json'), { merge: true, base: config.dest }))
      .pipe(gulp.dest(config.dest))
  })
}
