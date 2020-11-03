import './scripts/publicPath'
import './scripts/loadCustomElements'
import 'normalize.css/normalize.css'
import './main.scss'
import $ from 'jquery'
import feather from 'feather-icons'
import 'lazysizes'

window.jQuery = $

$(document).ready(function () {
  feather.replace({
    'stroke-width': 1
  })
})

function importAll (r) {
  r.keys().forEach(r)
}

importAll(require.context('../Components/', true, /\/script\.js$/))
