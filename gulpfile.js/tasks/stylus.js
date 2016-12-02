const browserSync = require('browser-sync')
const changed = require('gulp-changed')
const gulp = require('gulp')
const path = require('path')
const rupture = require('rupture')
const sourcemaps = require('gulp-sourcemaps')
const stylus = require('gulp-stylus')
const gulpIf = require('gulp-if')

module.exports = function (config) {
  const isProduction = process.env.NODE_ENV === 'production'
  gulp.task('stylus', function () {
    return gulp.src(config.stylus)
    .pipe(changed(config.dest))
    .pipe(gulpIf(!isProduction, sourcemaps.init()))
    .pipe(stylus({
      compress: isProduction,
      use: [
        rupture()
      ],
      import: [
        path.resolve(__dirname, '../../Modules/_variables.styl'),
        path.resolve(__dirname, '../../node_modules/jeet/styl/index.styl')
      ]
    }))
    .pipe(gulpIf(!isProduction, sourcemaps.write(config.sourcemaps)))
    .pipe(gulp.dest(config.dest))
    .pipe(browserSync.stream())
  })
}
