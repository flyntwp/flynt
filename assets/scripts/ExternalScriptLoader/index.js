const providers = {}

// load all files from ./Providers folder into providers variable
function importAll (moduleRequire) {
  moduleRequire.keys().forEach(key => {
    providers[key.substr(2, key.length - 5)] = moduleRequire(key).init
  })
}
importAll(require.context('./Providers/', true, /\.js$/))

let instance

class ExternalScriptLoader {
  constructor () {
    if (!instance) {
      instance = this
    }
    return instance
  }

  static getInstance () {
    return instance || new ExternalScriptLoader()
  }

  initialize (type, options = {}) {
    if (!this[type]) {
      this[type] = providers[type](options)
    }
    return this[type]
  }
}

window.FlyntExternalScriptLoader = ExternalScriptLoader
