module.exports = function (config) {
  const gulp = require('gulp')
  const path = require('path')
  const fs = require('fs')
  let phpCsAvailable
  let binaryPath = path.resolve(process.cwd(), config.lint.phpcs.binaryPath)
  delete config.lint.phpcs.binaryPath

  try {
    fs.accessSync(binaryPath, fs.constants.F_OK | fs.constants.X_OK)
    phpCsAvailable = true
  } catch (error) {
    const hasbin = require('hasbin')
    if (hasbin.sync('phpcs')) {
      phpCsAvailable = true
      binaryPath = ''
    }
  }

  gulp.task('lint:stylus', function () {
    const stylint = require('gulp-stylint')
    const changedInPlace = require('gulp-changed-in-place')
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
    const eslint = require('gulp-eslint')
    const reporter = require('gulp-reporter')
    const changedInPlace = require('gulp-changed-in-place')
    let opts = {}
    let task = gulp.src(config.lint.js)
    .pipe(changedInPlace({firstPass: true}))
    .pipe(eslint())
    .pipe(reporter())
    if (!global.watchMode) {
      task = task.pipe(eslint.failAfterError())
    }
    return task
  })

  gulp.task('lint:php', function (cb) {
    if (phpCsAvailable) {
      const phpcs = require('gulp-phpcs')
      const changedInPlace = require('gulp-changed-in-place')
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

  if (phpCsAvailable) {
    gulp.task('lint', gulp.parallel(['lint:stylus', 'lint:js', 'lint:php']))
  } else {
    const log = require('fancy-log')
    const colors = require('ansi-colors')
    log(colors.yellow('PHPCS not found in PATH! Please install PHPCS to enable the php linter:'))
    log(colors.yellow.underline('https://github.com/squizlabs/PHP_CodeSniffer'))

    gulp.task('lint', ['lint:stylus', 'lint:js'])
  }
}
