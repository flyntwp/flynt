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
  let phpCsAvailable
  let binaryPath = path.resolve(process.cwd(), config.lint.phpcs.binaryPath)
  delete config.lint.phpcs.binaryPath

  try {
    fs.accessSync(binaryPath, fs.constants.F_OK | fs.constants.X_OK)
    phpCsAvailable = true
  } catch (error) {
    if (hasbin.sync('phpcs')) {
      phpCsAvailable = true
      binaryPath = ''
    }
  }

  if (phpCsAvailable) {
    gulp.task('lint', ['lint:stylus', 'lint:js', 'lint:php'])
  } else {
    gutil.log(gutil.colors.yellow('PHPCS not found in PATH! Please install PHPCS to enable the php linter:'))
    gutil.log(gutil.colors.yellow.underline('https://github.com/squizlabs/PHP_CodeSniffer'))

    gulp.task('lint', ['lint:stylus', 'lint:js'])
  }

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

  gulp.task('lint:php', function (cb) {
    if (phpCsAvailable) {
      config.lint.phpcs.bin = binaryPath
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
    cb()
  })
}
