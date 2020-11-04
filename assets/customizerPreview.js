/* globals wp, FlyntCustomizerFields */
import $ from 'jquery'
import { hexToHsla } from './scripts/helpers'
import WebFont from 'webfontloader'

$(function () {
  const $root = $(':root.html')
  const setFieldValue = function (field) {
    return function (setting) {
      setting.bind(function (value) {
        const variable = `--${field.name}`

        console.log('seeting triggere', variable)

        if (field.type === 'flynt-typography') {
          const fontFamily = [
            value.family,
            field.fallback,
            value.category
          ]

          const webFontLoad = [
            value.family,
            value.variants.join(','),
            value.subsets.join(',')
          ].filter(Boolean).join(':')

          WebFont.load({
            google: {
              families: [`${webFontLoad}`]
            }
          })

          value = fontFamily.join(', ')
        } else if (field.type === 'flynt-range') {
          if (field.unit) {
            value = `${value}${field.unit}`
          }
        } else if (field.type === 'color') {
          if (field.hsl) {
            const hsla = hexToHsla(value)
            $root.css(`${variable}-h`, hsla[0])
            $root.css(`${variable}-s`, hsla[1])
            $root.css(`${variable}-l`, hsla[2])
          }
        }

        $root.css(variable, value)
      })
    }
  }

  for (const field of FlyntCustomizerFields) {
    wp.customize(field.name, setFieldValue(field))
  }
})
