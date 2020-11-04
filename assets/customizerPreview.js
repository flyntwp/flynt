/* globals wp, FlyntCustomizerFields */
import $ from 'jquery'
import { hexToHsla } from './scripts/helpers'
import WebFont from 'webfontloader'

$(function () {
  const $root = $(':root.html')
  const setFieldValue = function (field) {
    return function (setting) {
      setting.bind(function (value) {
        let variable = `--${field.name}`

        if (field.type === 'flynt-typography') {
          let variant = value.variant
          if (field.italic) {
            variant = `${variant},${variant}italic`
          }

          WebFont.load({
            google: {
              families: [`${value.family}:${variant}`]
            }
          })

          $root.css(`${variable}-weight`, value.variant)

          variable = `${variable}-family`
          value = [
            value.family,
            field.fallback,
            value.category
          ].join(', ')

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
