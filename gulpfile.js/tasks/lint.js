const gulp = require('gulp')
const gutil = require('gulp-util')
const changedInPlace = require('gulp-changed-in-place')
const stylint = require('gulp-stylint')
const standard = require('gulp-standard')
const phpcs = require('gulp-phpcs')
const hasbin = require('hasbin')
const path = require('path')
const fs = require('fs')

module.exports = function (config) {
  gulp.task('lint', ['lint:stylus', 'lint:js', 'lint:php'])

  gulp.task('lint:stylus', function () {
    const task = gulp.src(config.lint.stylus)
    .pipe(changedInPlace({firstPass: true}))
    .pipe(stylint())
    .pipe(stylint.reporter())
    if (global.watchMode) {
      return task
    } else {
      return task
      .pipe(stylint.reporter('fail', { failOnWarning: true }))
    }
  })

  gulp.task('lint:js', function () {
    let opts = {}
    if (!global.watchMode) {
      opts = {
        breakOnError: true,
        breakOnWarning: true
      }
    }
    return gulp.src(config.lint.js)
    .pipe(changedInPlace({firstPass: true}))
    .pipe(standard())
    .pipe(standard.reporter('default', opts))
  })

  gulp.task('lint:php', function () {
    // TODO should do these checks in the very beginning and then enable / disable php linting!
    // Check if phpcs is installed in boilerplate vendor
    const binaryPath = path.resolve(process.cwd(), '../../../../', 'vendor', 'bin', 'phpcs')
    fs.access(binaryPath, fs.constants.F_OK | fs.constants.X_OK, function (err) {
      // Binary Exists in vendor
      if (!err) {
        return runPhpCs(binaryPath)
      }

      // Check if a binary exists on process.env.PATH
      hasbin('phpcs', function (result) {
        if (!result) {
          gutil.log(gutil.colors.yellow('PHPCS not found in PATH! Please install PHPCS to enable the php linter:'))
          gutil.log(gutil.colors.yellow.underline('https://github.com/squizlabs/PHP_CodeSniffer'))
        } else {
          return runPhpCs()
        }
      })
    })
  })

  function runPhpCs (binaryPath = '') {
    if (binaryPath) {
      config.lint.phpcs.bin = binaryPath
    }
    const task = gulp.src(config.lint.php)
    .pipe(changedInPlace({firstPass: true}))
    .pipe(phpcs(config.lint.phpcs))
    .pipe(phpcs.reporter('log'))
    if (global.watchMode) {
      return task
    } else {
      return task
      .pipe(phpcs.reporter('fail', {failOnFirst: false}))
    }
  }
}
