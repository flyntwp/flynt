/* globals wp, Option */
import $ from 'jquery'

wp.customize.controlConstructor['flynt-typography'] = wp.customize.Control.extend({
  ready: function () {
    const $family = this.container.find('.flynt-typography-family')
    const $variant = this.container.find('.flynt-typography-variant')
    let family = this.params.value.family
    let category = this.params.value.category

    $family.select2({
      data: Object.values(this.params.fonts)
    })

    $variant.select2()

    $family.val(this.params.font).trigger('change')

    const addOptions = function (options, selected = '') {
      $variant.empty()

      for (const option of options) {
        const isSelected = (selected === option)
        const newOption = new Option(option, option, isSelected, isSelected)
        $variant.append(newOption).trigger('change')
      }
    }

    $family.on('select2:select', (e) => {
      const data = e.params.data
      const variants = this.params.fonts[data.id].variants
      family = data.family
      category = data.category

      addOptions(variants)
      this.setting.set({
        family: family,
        category: category,
        variant: variants[0]
      })
    })

    $variant.on('select2:select', (e) => {
      const data = e.params.data
      this.setting.set({
        family: family,
        category: category,
        variant: data.id
      })
    })

    this.container.on('click', '.flynt-typography-reset', (e) => {
      const $el = $(e.currentTarget)
      const id = $el.data('key')
      const variants = this.params.fonts[id].variants
      const selected = this.params.default.variant

      addOptions(variants, selected)
      this.setting.set(this.params.default)
      $family.val(id).trigger('change')
    })
  }
})
