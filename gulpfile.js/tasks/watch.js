const gulp = require('gulp')
const path = require('path')
const fs = require('fs')
let watch, touch, globby

const extensionMappings = {
  '.styl': '.css'
}

function watchAndDelete (src, callback, dest) {
  return watch(src, {
    events: ['add', 'change', 'unlink', 'unlinkDir']
  }, callback)
  .on('data', function (file) {
    if (file.event === 'unlink') {
      const filePath = path.join(dest, file.relative)
      if (fs.existsSync(filePath)) {
        fs.unlinkSync(filePath)
      }
      if (extensionMappings[file.extname]) {
        const relativeDest = path.dirname(filePath)
        const mappedFilePath = path.join(relativeDest, file.stem + extensionMappings[file.extname])
        if (fs.existsSync(mappedFilePath)) {
          fs.unlinkSync(mappedFilePath)
        }
      }
    }
    if (file.event === 'unlinkDir') {
      const dirPath = path.join(dest, file.relative)
      if (fs.existsSync(dirPath)) {
        const del = require('del')
        return del(dirPath, {force: true})
      }
    }
  })
}

function watchWebpack (src) {
  watch(src)
  .on('data', function (file) {
    const webpackTask = require('./webpack')
    if (webpackTask.watching) {
      if (file.event === 'add' || file.event === 'unlink') {
        webpackTask.watching.invalidate()
      }
    }
  })
}

function findFileInParentDirectory (filename, directory, stopSearchDirnames = []) {
  if (stopSearchDirnames.includes(directory)) { return null }
  if (!directory) {
    directory = path.dirname(module.parent.filename)
  }
  const file = path.resolve(directory, filename)
  if (fs.existsSync(file) && fs.statSync(file).isFile()) {
    return file
  }
  const parent = path.resolve(directory, '..')
  if (parent === directory) {
    return null
  }
  return findFileInParentDirectory(filename, parent, stopSearchDirnames)
}

function checkForStylusPartial (file, config) {
  if (file.basename[0] === config.watch.stylusPartials.partialCssFilenamePrefix) {
    const fileDir = path.dirname(path.join(process.cwd(), file.relative))
    const styleCssFilepath = findFileInParentDirectory(
      config.watch.stylusPartials.rootCssFilename,
      fileDir,
      config.watch.stylusPartials.stopSearchDirnames
    )
    if (styleCssFilepath !== null && fs.existsSync(styleCssFilepath)) {
      touch.sync(styleCssFilepath)
    }
  }
}

function checkForCssVariablesStyl (file, config) {
  if (config.watch.hardReloadOnStylFiles.includes(file.relative)) {
    globby(config.stylus, {}).then((files) => {
      Promise.all(
        files.map(function (file) {
          return new Promise((resolve, reject) => {
            touch(file, {}, (err) => {
              if (err) reject(err)
              resolve(file)
            })
          })
        }, [])
      )
    })
  }
}

module.exports = function (config) {
  gulp.task('watch:files', function () {
    globby = require('globby')
    touch = require('touch')
    watch = require('gulp-watch')
    watchAndDelete(config.copy, function () { gulp.start('copy') }, config.dest)
    watchAndDelete(config.watch.stylus, function (file) {
      checkForStylusPartial(file, config)
      checkForCssVariablesStyl(file, config)
      gulp.start('stylus')
    }, config.dest)
    watch(config.watch.php, function () { })
    watchWebpack(config.webpack.entry)
  })
  gulp.task('watch', function (cb) {
    const runSequence = require('run-sequence')
    runSequence(
      ['webpack:watch', 'browserSync'],
      'watch:files',
      cb
    )
  })
}
