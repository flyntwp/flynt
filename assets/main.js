import './scripts/publicPath'
import './scripts/loadCustomElements'
import 'normalize.css/normalize.css'
import './main.scss'
import $ from 'jquery'
import feather from 'feather-icons'
import 'lazysizes'

if ($('.iconList--checkCircle').length) {
  $('.iconList--checkCircle li').prepend('<i data-feather=check-circle></i>')
}

$(document).ready(function () {
  feather.replace({
    'stroke-width': 1.5
  })
})

function importAll (r) {
  r.keys().forEach(r)
}

importAll(require.context('../Components/', true, /\/script\.js$/))
