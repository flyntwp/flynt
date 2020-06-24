/* globals wp */
import $ from 'jquery'

$(document).ready(function () {
  wp.customize('theme_colors_accent', function (value) {
    value.bind(function (newval) {
      $(':root.html').css('--color-accent', newval)
      // TODO: .iconList--checkCircle li::before, jquery can't target pseudo element directly
    })
  })

  wp.customize('theme_colors_text', function (value) {
    value.bind(function (newval) {
      $(':root.html').css('--color-text', newval)
    })
  })

  wp.customize('theme_colors_headline', function (value) {
    value.bind(function (newval) {
      $(':root.html').css('--color-headline', newval)
      $('.themeReset select, select').css('background-image', 'url("data:image/svg+xml;charset=utf8,%3Csvg width=\'32\' height=\'32\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpolyline fill=\'none\' stroke=\'' + encodeURIComponent(newval) + '\' stroke-width=\'5\' points=\'2,9 16,25 30,9\'/%3E%3C/svg%3E")')
    })
  })

  wp.customize('theme_colors_brand', function (value) {
    value.bind(function (newval) {
      $(':root.html').css('--color-brand', newval)
    })
  })

  wp.customize('theme_colors_background-light', function (value) {
    value.bind(function (newval) {
      $(':root.html').css('--color-background-light', newval)
    })
  })

  wp.customize('theme_colors_background-dark', function (value) {
    value.bind(function (newval) {
      $(':root.html').css('--color-background-dark', newval)
    })
  })
})
