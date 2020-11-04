/* globals wp */
import $ from 'jquery'

wp.customize.controlConstructor['flynt-typography'] = wp.customize.Control.extend({
  ready: function () {
    const control = this
    const $select = this.container.find('select')
    const $variants = this.container.find('.flynt-typography-variants')
    const $subsets = this.container.find('.flynt-typography-subsets')
    let settings = control.params.value

    $select.select2({
      data: Object.values(control.params.fonts)
    })

    console.log('control', control)
    $select.val(control.params.font).trigger('change')

    const addOptions = function (element, options, selected = []) {
      for (const option of options) {
        const $label = $('<label>')

        $('<input>', {
          value: option,
          type: 'checkbox',
          checked: selected.includes(option)
        }).appendTo($label)

        $('<span>', {
          text: option
        }).appendTo($label)

        $label.appendTo(element)
      }
    }

    $select.on('select2:select', (e) => {
      const data = e.params.data
      const id = data.id

      settings = {
        family: data.family,
        subsets: [],
        variants: [],
        category: data.category
      }

      control.setting.set(settings)

      $variants.empty()
      $subsets.empty()

      addOptions($variants, control.params.fonts[id].variants)
      addOptions($subsets, control.params.fonts[id].subsets)
    })

    this.container.on('change', '.flynt-typography-variants input', function (e) {
      const $el = $(this)
      const $parent = $el.closest('.flynt-typography-variants')
      const variants = []

      $parent.find('input').each(function (index, element) {
        if (element.checked) {
          variants.push(element.value)
        }
      })

      settings.variants = variants
      control.setting.set(settings)

      console.log('seetings variants', control)
      // control.setting.sync()
      // control.setting.set(settings)
      // control.parent.trigger("change", control)
      // $select.val('roboto').trigger('change')
    })

    this.container.on('change', '.flynt-typography-subsets input', function (e) {
      const $el = $(this)
      const $parent = $el.closest('.flynt-typography-subsets')
      const subsets = []

      $parent.find('input').each(function (index, element) {
        if (element.checked) {
          subsets.push(element.value)
        }
      })

      settings.subsets = subsets
      console.log('seetings subsets', settings)
      control.setting.set(settings)
    })

    this.container.on('click', '.flynt-typography-reset', function () {
      const $el = $(this)
      const id = $el.data('key')

      $select.val(id).trigger('change')

      $variants.empty()
      $subsets.empty()

      addOptions($variants, control.params.fonts[id].variants, control.params.default.variants)
      addOptions($subsets, control.params.fonts[id].subsets, control.params.default.subsets)

      control.setting.set(control.params.default)
    })
  }
})
