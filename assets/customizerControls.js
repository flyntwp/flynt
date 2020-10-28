import $ from 'jquery'
import './customizerControls.scss'

$(document).on('change input', '.flynt-range', function () {
  const $el = $(this)
  const change = $el.data('change')
  $el.parent().find(`.flynt-range-${change}`).val($el.val())
})

$(document).on('click', '.flynt-range-reset', function () {
  const $el = $(this)
  const value = $el.data('default')
  $el.parent().find('.flynt-range').val(value)
})

// (function (wp, $) {
// wp.customize.controlConstructor['flynt-range'] = wp.customize.Control.extend({
//   ready: function () {
//     const control = this

//     this.container.on('change', '.flynt-range[type=range]', function () {
//       console.log('this range', this)
//       const $range = $(this)
//       const $number = $range.next()
//       $number.val($range.val())
//       control.setting.set($range.val());
//     })
//   }
// })
// })(wp, $)
