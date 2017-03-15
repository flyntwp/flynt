const autoprefixer = require('autoprefixer-stylus')
const browserSync = require('browser-sync')
const changed = require('gulp-changed')
const gulp = require('gulp')
const gulpIf = require('gulp-if')
const path = require('path')
const rupture = require('rupture')
const sourcemaps = require('gulp-sourcemaps')
const stylus = require('gulp-stylus')

module.exports = function (config) {
  const isProduction = process.env.NODE_ENV === 'production'
  gulp.task('stylus', function () {
    return gulp.src(config.stylus)
    .pipe(changed(config.dest))
    .pipe(gulpIf(!isProduction, sourcemaps.init()))
    .pipe(stylus({
      compress: isProduction,
      use: [
        rupture(),
        autoprefixer()
      ],
      import: [
        path.resolve(__dirname, '../../Components/_variables.styl'),
        path.resolve(__dirname, '../../node_modules/jeet/styl/index.styl')
      ]
    }))
    .pipe(gulpIf(!isProduction, sourcemaps.write(config.sourcemaps)))
    .pipe(gulp.dest(config.dest))
    .pipe(browserSync.stream())
  })
}
