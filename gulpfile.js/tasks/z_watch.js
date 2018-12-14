const gulp = require('gulp')
const path = require('path')
const fs = require('fs')
let touch, globby

const extensionMappings = {
  '.styl': '.css'
}

function watchAndDelete (src, callback, dest) {
  return gulp.watch(src, {
    events: ['add', 'change', 'unlink', 'unlinkDir']
  }, callback)
    .on('all', function (event, relativePath) {
      if (event === 'unlink') {
        const filePath = path.join(dest, relativePath)
        if (fs.existsSync(filePath)) {
          fs.unlinkSync(filePath)
        }
        const extname = path.extname(relativePath)
        if (extensionMappings[extname]) {
          const relativeDest = path.dirname(filePath)
          const mappedFilePath = path.join(relativeDest, path.basename(relativePath, extname) + extensionMappings[extname])
          if (fs.existsSync(mappedFilePath)) {
            fs.unlinkSync(mappedFilePath)
          }
        }
      }
      if (event === 'unlinkDir') {
        const dirPath = path.join(dest, relativePath)
        if (fs.existsSync(dirPath)) {
          const del = require('del')
          return del(dirPath, { force: true })
        }
      }
    })
}

function watchWebpack (src) {
  gulp.watch(src, {
    events: ['add', 'unlink']
  })
    .on('all', function (event) {
      const webpackTask = require('./webpack')
      if (webpackTask.watching) {
        if (event === 'add' || event === 'unlink') {
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

function checkForStylusPartial (relativePath, config) {
  if (path.basename(relativePath)[0] === config.watch.stylusPartials.partialCssFilenamePrefix) {
    const fileDir = path.dirname(path.join(process.cwd(), relativePath))
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

function checkForCssVariablesStyl (relativePath, config) {
  if (config.watch.hardReloadOnStylFiles.includes(relativePath)) {
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
    const browserSync = require('browser-sync')
    globby = require('globby')
    touch = require('touch')
    watchAndDelete(config.copy, gulp.series('copy'), config.dest)
    watchAndDelete(config.watch.stylus, gulp.series('stylus'), config.dest)
      .on('all', function (event, relativePath) {
        checkForStylusPartial(relativePath, config)
        checkForCssVariablesStyl(relativePath, config)
      })
    gulp.watch(config.watch.php, function () { browserSync.reload() })
    watchWebpack(config.webpack.entry)
  })
  gulp.task(
    'watch',
    gulp.parallel(['webpack:watch', 'browserSync', 'watch:files'])
  )
}
