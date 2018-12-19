const gulp = require('gulp')

module.exports = function (config) {
  const isProduction = process.env.NODE_ENV === 'production'
  gulp.task('sass', function () {
    const changed = require('gulp-changed')
    const gulpIf = require('gulp-if')
    // const handleErrors = require('../utils/handleErrors')
    const sass = require('gulp-sass')
    sass.compiler = require('node-sass')
    const sourcemaps = require('gulp-sourcemaps')
    const autoprefixer = require('gulp-autoprefixer')
    let task = gulp.src(config.sass)
      .pipe(changed(config.dest, { extension: '.css' }))
      .pipe(gulpIf(!isProduction, sourcemaps.init()))
      .pipe(sass({
        output: isProduction ? 'compressed' : 'expanded'
      }).on('error', sass.logError))
      .pipe(autoprefixer())
      // .on('error', handleErrors)
      .pipe(gulpIf(!isProduction, sourcemaps.write(config.sourcemaps)))
      .pipe(gulp.dest(config.dest))
      // .on('error', handleErrors)
    if (global.watchMode) {
      const browserSync = require('browser-sync')
      task = task.pipe(browserSync.stream())
    }
    return task
  })
}
