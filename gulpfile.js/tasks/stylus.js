const browserSync = require('browser-sync')
const changed = require('gulp-changed')
const gulp = require('gulp')
const path = require('path')
const rupture = require('rupture')
const sourcemaps = require('gulp-sourcemaps')
const stylus = require('gulp-stylus')

module.exports = function (config) {
  gulp.task('stylus', function () {
    return gulp.src(config.stylus)
    .pipe(changed(config.dest))
    .pipe(sourcemaps.init())
    .pipe(stylus({
      use: [
        rupture()
      ],
      import: [path.resolve(__dirname, '../../node_modules/jeet/styl/index.styl')]
    }))
    .pipe(sourcemaps.write(config.sourcemaps))
    .pipe(gulp.dest(config.dest))
    .pipe(browserSync.stream())
  })
}
