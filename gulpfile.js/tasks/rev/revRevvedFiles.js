const gulp = require('gulp')
const path = require('path')
const rev = require('gulp-rev')
const revNapkin = require('gulp-rev-napkin')

module.exports = function(config) {
  // 3) Rev and compress CSS and JS files (this is done after assets, so that if a
  //    referenced asset hash changes, the parent hash will change as well
  gulp.task('revRevvedFiles', function(){
    return gulp.src(config.rev.srcRevved)
    .pipe(rev({
      replaceInExtensions: config.rev.revvedFileExtensions
    }))
    .pipe(gulp.dest(config.dest))
    .pipe(revNapkin({verbose: false}))
    .pipe(rev.manifest(path.join(config.dest, 'rev-manifest.json'), {merge: true}))
    .pipe(gulp.dest(''))
  })
}
