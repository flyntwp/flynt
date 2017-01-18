function addComponentScriptsToWebpackEntries (componentName) { // eslint-disable-line no-unused-vars
  /*
    INFO: Cannot use resolveLoader in webpack config for this,
    because of a bug that's been fixed only for webpack 2.

    https://github.com/webpack/enhanced-resolve/pull/22
  */
  require(`../gulpfile.js/webpack/entryLoader.js?name=[name]/script.js!./${componentName}/script.js`)
  require(`../gulpfile.js/webpack/entryLoader.js?name=[name]!./${componentName}/admin.js`)
  require(`../gulpfile.js/webpack/entryLoader.js?name=[name]!./${componentName}/auth.js`)
}
