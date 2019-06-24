import './admin.scss'
import $ from 'jquery'

$(document).ready(function () {
  var waitForEl = function (selector, callback) {
    if ($(selector).length) {
      callback()
    } else {
      setTimeout(function () {
        waitForEl(selector, callback)
      }, 100)
    }
  }

  if ($('[data-layout="BlockCountUp"]').closest('.values').length) {
    waitForEl('i[data-feather]', function () {
      $('i[data-feather]').closest('.select2-selection__rendered').removeAttr('title')
      window.feather.replace()
    })
  }

  $('body').on('click', '.select2-container', function () {
    window.feather.replace()
  })

  $('body').on('change', '.select2-hidden-accessible', function () {
    window.feather.replace()
  })

  $('body').on('keyup', '.select2-search__field', function () {
    window.feather.replace()
  })
})

function importAll (r) {
  r.keys().forEach(r)
}

importAll(require.context('../Components/', true, /admin\.js$/))
