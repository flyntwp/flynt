const gulp = require('gulp')
const path = require('path')
const fs = require('fs')

const extensionMappings = {
  '.styl': '.css'
}

function watchAndDelete (src, callback, dest) {
  return gulp.watch(src, {
    events: ['add', 'change', 'unlink', 'unlinkDir']
  }, callback)
    .on('all', function (event, relativePath) {
      if (event === 'unlink') {
        const filePath = path.join(dest, relativePath)
        if (fs.existsSync(filePath)) {
          fs.unlinkSync(filePath)
        }
        const extname = path.extname(relativePath)
        if (extensionMappings[extname]) {
          const relativeDest = path.dirname(filePath)
          const mappedFilePath = path.join(relativeDest, path.basename(relativePath, extname) + extensionMappings[extname])
          if (fs.existsSync(mappedFilePath)) {
            fs.unlinkSync(mappedFilePath)
          }
        }
      }
      if (event === 'unlinkDir') {
        const dirPath = path.join(dest, relativePath)
        if (fs.existsSync(dirPath)) {
          const del = require('del')
          return del(dirPath, { force: true })
        }
      }
    })
}

module.exports = function (config) {
  gulp.task('watch:files', function () {
    const browserSync = require('browser-sync')
    watchAndDelete(config.copy, gulp.series('copy'), config.dest)
    gulp.watch(config.watch.sass, gulp.series('sass'))
    gulp.watch(config.watch.php, function () { browserSync.reload() })
  })
  gulp.task(
    'watch',
    gulp.parallel(['webpack:watch', 'browserSync', 'watch:files'])
  )
}
