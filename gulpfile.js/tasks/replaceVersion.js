const gulp = require('gulp')

module.exports = function (config) {
  gulp.task('replaceVersion', function (cb) {
    const log = require('fancy-log')
    const colors = require('ansi-colors')
    const PluginError = require('plugin-error')
    const pjson = require('../../package.json')
    const replace = require('replace-in-file')
    try {
      // read current version from package.json
      config.replaceVersion.php.to = pjson.version
      log(`Replacing ${config.replaceVersion.php.from} with ${config.replaceVersion.php.to} in all PHP files.`)
      const changedFilesPhp = replace.sync(config.replaceVersion.php)
      for (const file of changedFilesPhp) {
        log(`Updated ${file}`)
      }

      // replace WordPress theme version in style.css
      log('Updating WordPress theme version.')
      config.replaceVersion.wordpress.to += pjson.version
      const changedFilesWp = replace.sync(config.replaceVersion.wordpress)
      if (changedFilesWp.length > 0) {
        for (const file of changedFilesWp) {
          log(`Updated ${file}`)
        }
      } else {
        log(colors.yellow('No changes made! Was the version already changed?'))
      }
    } catch (error) {
      throw new PluginError('replaceVersion', error)
    }
    cb()
  })
}
