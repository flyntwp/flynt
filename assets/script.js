import 'file-loader?name=vendor/console.js!uglify-loader!console-polyfill'
import 'file-loader?name=vendor/babel-polyfill.js!@babel/polyfill/dist/polyfill.min'
import 'file-loader?name=vendor/normalize.css!csso-loader!normalize.css/normalize.css'
import 'file-loader?name=vendor/lazysizes.js!uglify-loader!lazysizes'

import installCE from 'document-register-element/pony'

window.lazySizesConfig = window.lazySizesConfig || {}
window.lazySizesConfig.preloadAfterLoad = true

installCE(window, {
  type: 'force',
  noBuiltIn: true
})

function importAll (r) {
  r.keys().forEach(r);
}

importAll(require.context('../Components/', true, /script\.js$/))
importAll(require.context('../Features/', true, /script\.js$/))
