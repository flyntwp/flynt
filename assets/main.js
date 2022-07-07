import './scripts/publicPath'
import './scripts/loadCustomElements'
import 'normalize.css/normalize.css'
import './main.scss'
import feather from 'feather-icons'
import 'lazysizes'

// feather-icons
document.addEventListener('DOMContentLoaded', function () {
  // Prepare .iconList--checkCircle
  const iconListCheckCircleElements = document.querySelectorAll('.iconList--checkCircle')
  iconListCheckCircleElements.forEach(function (element) {
    const children = [...element.children]
    children.forEach(function (child) {
      child.insertAdjacentHTML('afterbegin', '<i data-feather=check-circle></i>')
    })
  })

  // Set feather-icons stroke width
  const borderWidth = window.getComputedStyle(document.documentElement).getPropertyValue('--border-width')
    ? parseInt(window.getComputedStyle(document.documentElement).getPropertyValue('--border-width'))
    : 1.5
  feather.replace({
    'stroke-width': borderWidth
  })
})

function importAll (r) {
  r.keys().forEach(r)
}

importAll(require.context('../Components/', true, /\/script\.js$/))
