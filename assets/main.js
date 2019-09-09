/* global PREMIUM_COMPONENTS_EXIST */
import 'console-polyfill'
import 'normalize.css/normalize.css'
import './main.scss'
import $ from 'jquery'

import installCE from 'document-register-element/pony'

window.lazySizesConfig = window.lazySizesConfig || {}
window.lazySizesConfig.preloadAfterLoad = true
require('lazysizes')

$(document).ready(function () {
  window.feather.replace({
    'stroke-width': 1
  })
})

installCE(window, {
  type: 'force',
  noBuiltIn: true
})

function importAll (r) {
  r.keys().forEach(r)
}

importAll(require.context('../Components/', true, /script\.js$/))
if (PREMIUM_COMPONENTS_EXIST) {
  importAll(require.context('../FlyntPremium/Components/', true, /script\.js$/))
}
