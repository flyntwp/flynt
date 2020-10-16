/* globals wp */
import $ from 'jquery'

function hexToRgba (color, opacity = 1, returnType = 'array') {
  let r = 0
  let g = 0
  let b = 0

  if (color.length === 4) {
    r = '0x' + color[1] + color[1]
    g = '0x' + color[2] + color[2]
    b = '0x' + color[3] + color[3]
  } else if (color.length === 7) {
    r = '0x' + color[1] + color[2]
    g = '0x' + color[3] + color[4]
    b = '0x' + color[5] + color[6]
  }

  const rgba = [r, g, b, opacity]

  if (returnType === 'string') {
    return `rgba(${rgba.join(',')})`
  }

  return rgba
}

function hexToHsla (color, opacity = 1, returnType = 'array') {
  const rgba = hexToRgba(color)
  const r = rgba[0] / 255
  const g = rgba[1] / 255
  const b = rgba[2] / 255

  const min = Math.min(r, g, b)
  const max = Math.max(r, g, b)
  const delta = max - min

  let h = 0
  let s = 0
  let l = 0

  if (delta > 0) {
    if (max === r) {
      h = ((g - b) / delta) % 6
    } else if (max === g) {
      h = (b - r) / delta + 2
    } else {
      h = (r - g) / delta + 4
    }
  }

  h = Math.round(h * 60)

  if (h < 0) {
    h += 360
  }

  l = (min + max) / 2
  s = delta === 0 ? 0 : delta / (1 - Math.abs(2 * l - 1))

  s = (s * 100).toFixed(1)
  l = (l * 100).toFixed(1)

  const hsla = [h, `${s}%`, `${l}%`, opacity]

  if (returnType === 'string') {
    return `hsla(${hsla.join(',')})`
  }

  return hsla
}

$(document).ready(function () {
  const $root = $(':root.html')
  const setColor = function (cssProperty) {
    return function (setting) {
      setting.bind(function (color) {
        $root.css(cssProperty, color)
      })
    }
  }
  const setColorWithHsla = function (cssProperty, theme) {
    return function (setting) {
      setting.bind(function (color) {
        const hsla = hexToHsla(color)
        $root.css(`${cssProperty}-${theme}`, color)
        $root.css(`${cssProperty}-h-${theme}`, hsla[0])
        $root.css(`${cssProperty}-s-${theme}`, hsla[1])
        $root.css(`${cssProperty}-l-${theme}`, hsla[2])
      })
    }
  }

  // Default / Theme Reset
  wp.customize('theme_colors_accent_default', setColorWithHsla('--theme-color-accent', 'default'))
  wp.customize('theme_colors_text_default', setColor('--theme-color-text-default'))
  wp.customize('theme_colors_headline_default', setColor('--theme-color-headline-default'))
  wp.customize('theme_colors_border_default', setColor('--theme-color-border-default'))
  wp.customize('theme_colors_background_default', setColor('--theme-color-background-default'))

  // Theme Light
  wp.customize('theme_colors_accent_light', setColorWithHsla('--theme-color-accent', 'light'))
  wp.customize('theme_colors_text_light', setColor('--theme-color-text-light'))
  wp.customize('theme_colors_headline_light', setColor('--theme-color-headline-light'))
  wp.customize('theme_colors_border_light', setColor('--theme-color-border-light'))
  wp.customize('theme_colors_background_light', setColor('--theme-color-background-light'))

  // Theme Dark
  wp.customize('theme_colors_accent_dark', setColorWithHsla('--theme-color-accent', 'dark'))
  wp.customize('theme_colors_text_dark', setColor('--theme-color-text-dark'))
  wp.customize('theme_colors_headline_dark', setColor('--theme-color-headline-dark'))
  wp.customize('theme_colors_border_dark', setColor('--theme-color-border-dark'))
  wp.customize('theme_colors_background_dark', setColor('--theme-color-background-dark'))

  // Theme Hero
  wp.customize('theme_colors_accent_hero', setColorWithHsla('--theme-color-accent', 'hero'))
  wp.customize('theme_colors_text_hero', setColor('--theme-color-text-hero'))
  wp.customize('theme_colors_headline_hero', setColor('--theme-color-headline-hero'))
  wp.customize('theme_colors_border_hero', setColor('--theme-color-border-hero'))
  wp.customize('theme_colors_background_hero', setColor('--theme-color-background-hero'))
})
