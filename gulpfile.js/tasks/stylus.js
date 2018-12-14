const gulp = require('gulp')

module.exports = function (config) {
  const isProduction = process.env.NODE_ENV === 'production'
  gulp.task('stylus', function () {
    const autoprefixer = require('autoprefixer-stylus')
    const changed = require('gulp-changed')
    const gulpIf = require('gulp-if')
    // const handleErrors = require('../utils/handleErrors')
    const path = require('path')
    const rupture = require('rupture')
    const stylus = require('gulp-stylus')
    const sourcemaps = require('gulp-sourcemaps')
    let task = gulp.src(config.stylus)
    .pipe(changed(config.dest, {extension: '.css'}))
    .pipe(gulpIf(!isProduction, sourcemaps.init()))
    .pipe(stylus({
      'include css': true,
      compress: isProduction,
      use: [
        rupture(),
        autoprefixer()
      ],
      import: [
        path.resolve(__dirname, '../../node_modules/jeet/styl/index.styl'),
        path.resolve(__dirname, '../../Components/_variables.styl')
      ]
    }))
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
