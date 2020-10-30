/* globals wp, FlyntCustomizerFields */
import $ from 'jquery'
import { hexToHsla } from './scripts/helpers'

$(function () {
  const $root = $(':root.html')
  const setFieldValue = function (field) {
    return function (setting) {
      setting.bind(function (value) {
        const variable = `--${field.name}`
        if (field.unit) {
          value = `${value}${field.unit}`
        }

        $root.css(variable, value)

        if (field.hsl) {
          const hsla = hexToHsla(value)
          $root.css(`${variable}-h`, hsla[0])
          $root.css(`${variable}-s`, hsla[1])
          $root.css(`${variable}-l`, hsla[2])
        }
      })
    }
  }

  for (const field of FlyntCustomizerFields) {
    wp.customize(field.name, setFieldValue(field))
  }
})
