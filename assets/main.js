import './scripts/publicPath'
import './scripts/loadCustomElements'
import { initFeatherIcons, addFeatherIconToListCheckCircle } from './scripts/helpersFeatherIcons'
import 'normalize.css/normalize.css'
import './main.scss'

import lazySizes from 'lazysizes'
import 'lazysizes/plugins/native-loading/ls.native-loading'
lazySizes.cfg.nativeLoading = {
  setLoadingAttribute: true,
  disableListeners: {
    scroll: true
  }
}

document.addEventListener('DOMContentLoaded', function () {
  addFeatherIconToListCheckCircle()
  initFeatherIcons()
})

function importAll (r) {
  r.keys().forEach(r)
}

importAll(require.context('../Components/', true, /\/script\.js$/))
