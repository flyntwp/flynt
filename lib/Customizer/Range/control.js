/* globals wp */
import $ from 'jquery'

wp.customize.controlConstructor['flynt-range'] = wp.customize.Control.extend({
  ready: function () {
    const control = this

    this.container.on('change', '.flynt-range', function () {
      const $el = $(this)
      const max = parseInt($el.attr('max'), 10)
      const min = parseInt($el.attr('min'), 10)
      let value = parseInt($el.val(), 10)

      if (min > value) {
        value = min
      }

      if (max < value) {
        value = max
      }

      control.setting.set(value)
    })

    this.container.on('click', '.flynt-range-reset', function () {
      const $el = $(this)
      const value = $el.data('default')
      control.setting.set(value)
    })
  }
})
