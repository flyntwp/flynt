import 'normalize.css/normalize.css'
import './main.scss'
import $ from 'jquery'

if (LEGACY) {
  require('console-polyfill')
  const installCE = require('document-register-element/pony')
  installCE(window, {
    type: 'force',
    noBuiltIn: true
  })
}

window.lazySizesConfig = window.lazySizesConfig || {}
window.lazySizesConfig.preloadAfterLoad = true
require('lazysizes')

$(document).ready(function () {
  window.feather.replace()
})

function importAll (r) {
  r.keys().forEach(r)
}

importAll(require.context('../Components/', true, /script\.js$/))
