/* globals wp, FlyntCustomizerData */
import $ from 'jquery'
import { hexToHsla } from './scripts/helpers'

$(document).ready(function () {
  const $root = $(':root.html')
  const setColor = function (cssProperty, options) {
    return function (setting) {
      setting.bind(function (color) {
        $root.css(`${cssProperty}`, color)
        if (options.hsl) {
          const hsla = hexToHsla(color)
          $root.css(`${cssProperty}-h`, hsla[0])
          $root.css(`${cssProperty}-s`, hsla[1])
          $root.css(`${cssProperty}-l`, hsla[2])
        }
      })
    }
  }

  for (const [themeKey, theme] of Object.entries(FlyntCustomizerData)) {
    for (const [colorName, options] of Object.entries(theme)) {
      wp.customize(`theme_${themeKey}_color_${colorName}`, setColor(`--theme-${themeKey}-color-${colorName}`, options))
    }
  }
})
