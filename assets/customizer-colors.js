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
  // Default / Theme Reset
  wp.customize('theme_colors_accent-default', function (value) {
    value.bind(function (newval) {
      $(':root.html').css('--theme-color-accent-default', newval)
      $(':root.html').css('--theme-color-accent-alpha-default', hexToRgbA(newval, alphaColorAmount))
      $(':root.html').css('--theme-color-accent-hover-default', lightenDarkenColor(newval, darkenColorAmount))
    })
  })

  wp.customize('theme_colors_text-default', function (value) {
    value.bind(function (newval) {
      $(':root.html').css('--theme-color-text', newval)
    })
  })

  wp.customize('theme_colors_headline-default', function (value) {
    value.bind(function (newval) {
      $(':root.html').css('--theme-color-headline', newval)
    })
  })

  wp.customize('theme_colors_border-default', function (value) {
    value.bind(function (newval) {
      $(':root.html').css('--theme-color-border', newval)
    })
  })

  wp.customize('theme_colors_background-default', function (value) {
    value.bind(function (newval) {
      $(':root.html').css('--theme-color-background', newval)
    })
  })

  // Theme Light
  wp.customize('theme_colors_accent-light', function (value) {
    value.bind(function (newval) {
      $(':root.html').css('--theme-color-accent-light', newval)
      $(':root.html').css('--theme-color-accent-alpha-light', newval ? hexToRgbA(newval, alphaColorAmount) : 'var(--theme-color-accent-alpha-default)')
      $(':root.html').css('--theme-color-accent-hover-light', newval ? lightenDarkenColor(newval, darkenColorAmount) : 'var(--theme-color-accent-hover-default)')
    })
  })

  wp.customize('theme_colors_text-light', function (value) {
    value.bind(function (newval) {
      $(':root.html').css('--theme-color-text-light', newval)
    })
  })

  wp.customize('theme_colors_headline-light', function (value) {
    value.bind(function (newval) {
      $(':root.html').css('--theme-color-headline-light', newval)
    })
  })

  wp.customize('theme_colors_border-light', function (value) {
    value.bind(function (newval) {
      $(':root.html').css('--theme-color-border-light', newval)
    })
  })

  wp.customize('theme_colors_background-light', function (value) {
    value.bind(function (newval) {
      $(':root.html').css('--theme-color-background-light', newval)
    })
  })

  // Theme Dark
  wp.customize('theme_colors_accent-dark', function (value) {
    value.bind(function (newval) {
      $(':root.html').css('--theme-color-accent-dark', newval)
      $(':root.html').css('--theme-color-accent-alpha-dark', hexToRgbA(newval, alphaColorAmount))
      $(':root.html').css('--theme-color-accent-hover-dark', lightenDarkenColor(newval, darkenColorAmount))
    })
  })

  wp.customize('theme_colors_text-dark', function (value) {
    value.bind(function (newval) {
      $(':root.html').css('--theme-color-text-dark', newval)
    })
  })

  wp.customize('theme_colors_headline-dark', function (value) {
    value.bind(function (newval) {
      $(':root.html').css('--theme-color-headline-dark', newval)
    })
  })

  wp.customize('theme_colors_border-dark', function (value) {
    value.bind(function (newval) {
      $(':root.html').css('--theme-color-border-dark', newval)
    })
  })

  wp.customize('theme_colors_background-dark', function (value) {
    value.bind(function (newval) {
      $(':root.html').css('--theme-color-background-dark', newval)
    })
  })

  // Theme Hero
  wp.customize('theme_colors_accent-hero', function (value) {
    value.bind(function (newval) {
      $(':root.html').css('--theme-color-accent-hero', newval)
      $(':root.html').css('--theme-color-accent-alpha-hero', hexToRgbA(newval, alphaColorAmount))
      $(':root.html').css('--theme-color-accent-hover-hero', lightenDarkenColor(newval, darkenColorAmount))
    })
  })

  wp.customize('theme_colors_text-hero', function (value) {
    value.bind(function (newval) {
      $(':root.html').css('--theme-color-text-hero', newval)
    })
  })

  wp.customize('theme_colors_headline-hero', function (value) {
    value.bind(function (newval) {
      $(':root.html').css('--theme-color-headline-hero', newval)
    })
  })

  wp.customize('theme_colors_border-hero', function (value) {
    value.bind(function (newval) {
      $(':root.html').css('--theme-color-border-hero', newval)
    })
  })

  wp.customize('theme_colors_background-hero', function (value) {
    value.bind(function (newval) {
      $(':root.html').css('--theme-color-background-hero', newval)
    })
  })
})
