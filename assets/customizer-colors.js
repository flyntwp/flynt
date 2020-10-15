/* globals wp */
import $ from 'jquery'

function hexToRgbA (hex, alpha) {
  let c
  if (/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)) {
    c = hex.substring(1).split('')
    if (c.length === 3) {
      c = [c[0], c[0], c[1], c[1], c[2], c[2]]
    }
    c = '0x' + c.join('')
    return 'rgba(' + [(c >> 16) & 255, (c >> 8) & 255, c & 255].join(',') + ',' + alpha + ')'
  }
}

function lightenDarkenColor (hex, amount) {
  let usePound = false

  if (hex[0] === '#') {
    hex = hex.slice(1)
    usePound = true
  }

  let R = parseInt(hex.substring(0, 2), 16)
  let G = parseInt(hex.substring(2, 4), 16)
  let B = parseInt(hex.substring(4, 6), 16)

  const positivePercent = amount - (amount * 2)
  R = Math.round(R * (1 - positivePercent))
  G = Math.round(G * (1 - positivePercent))
  B = Math.round(B * (1 - positivePercent))

  if (R > 255) R = 255
  else if (R < 0) R = 0

  if (G > 255) G = 255
  else if (G < 0) G = 0

  if (B > 255) B = 255
  else if (B < 0) B = 0

  const RR = ((R.toString(16).length === 1) ? '0' + R.toString(16) : R.toString(16))
  const GG = ((G.toString(16).length === 1) ? '0' + G.toString(16) : G.toString(16))
  const BB = ((B.toString(16).length === 1) ? '0' + B.toString(16) : B.toString(16))

  return (usePound ? '#' : '') + RR + GG + BB
}

const alphaColorAmount = 0.4
const darkenColorAmount = -0.1 // -0.1 darken value approximately equals scss darken 5%

$(document).ready(function () {
  const $root = $(':root.html')
  const setColor = function (cssProperty) {
    return function (setting) {
      setting.bind(function (color) {
        $root.css(cssProperty, color)
      })
    }
  }
  const setColorWithAlphaAndHover = function (cssProperty, theme) {
    return function (setting) {
      setting.bind(function (color) {
        $root.css(`${cssProperty}-${theme}`, color)
        $root.css(`${cssProperty}-alpha-${theme}`, hexToRgbA(color, alphaColorAmount))
        $root.css(`${cssProperty}-hover-${theme}`, lightenDarkenColor(color, darkenColorAmount))
      })
    }
  }

  // Default / Theme Reset
  wp.customize('theme_colors_accent_default', setColorWithAlphaAndHover('--theme-color-accent', 'default'))
  wp.customize('theme_colors_text_default', setColor('--theme-color-text-default'))
  wp.customize('theme_colors_headline_default', setColor('--theme-color-headline-default'))
  wp.customize('theme_colors_border_default', setColor('--theme-color-border-default'))
  wp.customize('theme_colors_background_default', setColor('--theme-color-background-default'))

  // Theme Light
  wp.customize('theme_colors_accent_light', setColorWithAlphaAndHover('--theme-color-accent', 'light'))
  wp.customize('theme_colors_text_light', setColor('--theme-color-text-light'))
  wp.customize('theme_colors_headline_light', setColor('--theme-color-headline-light'))
  wp.customize('theme_colors_border_light', setColor('--theme-color-border-light'))
  wp.customize('theme_colors_background_light', setColor('--theme-color-background-light'))

  // Theme Dark
  wp.customize('theme_colors_accent_dark', setColorWithAlphaAndHover('--theme-color-accent', 'dark'))
  wp.customize('theme_colors_text_dark', setColor('--theme-color-text-dark'))
  wp.customize('theme_colors_headline_dark', setColor('--theme-color-headline-dark'))
  wp.customize('theme_colors_border_dark', setColor('--theme-color-border-dark'))
  wp.customize('theme_colors_background_dark', setColor('--theme-color-background-dark'))

  // Theme Hero
  wp.customize('theme_colors_accent_hero', setColorWithAlphaAndHover('--theme-color-accent', 'hero'))
  wp.customize('theme_colors_text_hero', setColor('--theme-color-text-hero'))
  wp.customize('theme_colors_headline_hero', setColor('--theme-color-headline-hero'))
  wp.customize('theme_colors_border_hero', setColor('--theme-color-border-hero'))
  wp.customize('theme_colors_background_hero', setColor('--theme-color-background-hero'))
})
