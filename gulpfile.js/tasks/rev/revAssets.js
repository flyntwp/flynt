const gulp = require('gulp')
const path = require('path')
const rev = require('gulp-rev')
const revNapkin = require('gulp-rev-napkin')

module.exports = function (config) {
  // 1) Add md5 hashes to assets referenced by CSS and JS files
  gulp.task('revAssets', function () {
    // Ignore files that may reference assets. We'll rev them next.
    return gulp.src(config.rev.assetSrc)
    .pipe(rev())
    .pipe(gulp.dest(config.dest))
    .pipe(revNapkin({verbose: false}))
    .pipe(rev.manifest(path.join(config.dest, 'rev-manifest.json'), {merge: true}))
    .pipe(gulp.dest(''))
  })
}
