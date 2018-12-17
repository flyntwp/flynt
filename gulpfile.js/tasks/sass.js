const gulp = require('gulp')

module.exports = function (config) {
  const isProduction = process.env.NODE_ENV === 'production'
  gulp.task('sass', function () {
    // const autoprefixer = require('autoprefixer-stylus')
    const changed = require('gulp-changed')
    const gulpIf = require('gulp-if')
    const handleErrors = require('../utils/handleErrors')
    const path = require('path')
    const rupture = require('rupture')
    const sass = require('gulp-sass')
    const sourcemaps = require('gulp-sourcemaps')
    let task = gulp.src(config.sass)
      .pipe(changed(config.dest, { extension: '.css' }))
      .pipe(gulpIf(!isProduction, sourcemaps.init()))
      .pipe(sass({
        'include css': true,
        compress: isProduction,
        use: [
          rupture(),
          // autoprefixer()
        ],
        import: [
          path.resolve(__dirname, '../../node_modules/jeet/index.scss'),
          path.resolve(__dirname, '../../Components/_variables.sass')
        ]
      }))
      .on('error', handleErrors)
      .pipe(gulpIf(!isProduction, sourcemaps.write(config.sourcemaps)))
      .pipe(gulp.dest(config.dest))
      .on('error', handleErrors)
    if (global.watchMode) {
      const browserSync = require('browser-sync')
      task = task.pipe(browserSync.stream())
    }
    return task
  })
}
