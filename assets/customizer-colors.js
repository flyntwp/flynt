/* globals wp */
import $ from 'jquery'

$(document).ready(function () {
  wp.customize('theme_colors_accent', function (value) {
    value.bind(function (newval) {
      $(':root.html').css('--color-accent', newval)
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
