const gulp = require('gulp')
const gutil = require('gulp-util')
const pjson = require('../../package.json')
const replace = require('replace-in-file')

module.exports = function (config) {
  gulp.task('replaceVersion', function (cb) {
    try {
      // read current version from package.json
      config.replaceVersion.php.to = pjson.version
      gutil.log(`Replacing ${config.replaceVersion.php.from} with ${config.replaceVersion.php.to} in all PHP files.`)
      const changedFilesPhp = replace.sync(config.replaceVersion.php)
      for (const file of changedFilesPhp) {
        gutil.log(`Updated ${file}`)
      }

      // replace WordPress theme version in style.css
      gutil.log('Updating WordPress theme version.')
      config.replaceVersion.wordpress.to += pjson.version
      const changedFilesWp = replace.sync(config.replaceVersion.wordpress)
      if (changedFilesWp.length > 0) {
        for (const file of changedFilesWp) {
          gutil.log(`Updated ${file}`)
        }
      } else {
        gutil.log(gutil.colors.yellow('No changes made! Was the version already changed?'))
      }
    } catch (error) {
      gutil.error('An error occurred:', error)
    }
    cb()
  })
}
