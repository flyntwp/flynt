const browserSync = require('browser-sync')
const changed = require('gulp-changed')
const gulp = require('gulp')
const path = require('path')
const rupture = require('rupture')
const sourcemaps = require('gulp-sourcemaps')
const stylus = require('gulp-stylus')
const gulpIf = require('gulp-if')
const plumber = require('gulp-plumber')
const notify = require('gulp-notify')

module.exports = function (config) {
  const isProduction = process.env.NODE_ENV === 'production'
  gulp.task('stylus', function () {
    return gulp.src(config.stylus)
    .pipe(plumber({errorHandler: notify.onError({
      title: 'Flynt Theme',
      subtitle: 'Build failed',
      message: 'Error:\n <%= error.message %>',
      sound: 'Beep'
    })}))
    .pipe(changed(config.dest))
    .pipe(gulpIf(!isProduction, sourcemaps.init()))
    .pipe(stylus({
      compress: isProduction,
      use: [
        rupture()
      ],
      import: [
        path.resolve(__dirname, '../../Components/_variables.styl'),
        path.resolve(__dirname, '../../node_modules/jeet/styl/index.styl')
      ]
    }))
    .pipe(gulpIf(!isProduction, sourcemaps.write(config.sourcemaps)))
    .pipe(plumber.stop())
    .pipe(gulp.dest(config.dest))
    .pipe(browserSync.stream())
  })
}
