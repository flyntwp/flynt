const gulp = require('gulp')
const runSequence = require('run-sequence')

module.exports = function(config) {
  gulp.task('rev', function(cb) {
    return runSequence(
      // 1) Add md5 hashes to assets referenced by CSS and JS files
      'revAssets',
      // 2) Update asset references (images, fonts, etc) with reved filenames in compiled css + js
      'revUpdateReferences',
      // 3) Rev and compress CSS and JS files (this is done after assets, so that if a referenced asset hash changes, the parent hash will change as well
      'revRevvedFiles',
      // 4) Update asset references in HTML
      'revStaticFiles',
    cb)
  })
}
