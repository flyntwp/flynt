import './admin.scss'
import $ from 'jquery'

$(document).ready(function () {
  setTimeout(() => {
    window.feather.replace()
  }, 4000)

  $('.select2').on('select2:change', function (e) {
    console.log('change')
  })

  $('body').on('click', '.select2-container', function () {
    window.feather.replace()
  })

  $('body').on('change', '.select2-hidden-accessible', function () {
    window.feather.replace()
  })
})

function importAll (r) {
  r.keys().forEach(r)
}

importAll(require.context('../Components/', true, /admin\.js$/))
