import './scripts/publicPath'
import './scripts/loadCustomElements'
import { initFeatherIcons, addFeatherIconToListCheckCircle } from './scripts/helpersFeatherIcons'
import 'normalize.css/normalize.css'
import './main.scss'
import 'lazysizes'

document.addEventListener('DOMContentLoaded', function () {
  addFeatherIconToListCheckCircle()
  initFeatherIcons()
})

function importAll (r) {
  r.keys().forEach(r)
}

importAll(require.context('../Components/', true, /\/script\.js$/))
