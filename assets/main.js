import 'console-polyfill'
import 'normalize.css/normalize.css'
import './main.scss'

import installCE from 'document-register-element/pony'

window.lazySizesConfig = window.lazySizesConfig || {}
window.lazySizesConfig.preloadAfterLoad = true
require('lazysizes')

installCE(window, {
  type: 'force',
  noBuiltIn: true
})

function importAll (r) {
  r.keys().forEach(r)
}

importAll(require.context('../Components/', true, /script\.js$/))
