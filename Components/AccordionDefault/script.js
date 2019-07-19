import $ from 'jquery'

class AccordionDefault extends window.HTMLDivElement {
  constructor (...args) {
    const self = super(...args)
    self.init()
    return self
  }

  init () {
    this.$ = $(this)
    this.bindFunctions()
    this.bindEvents()
  }

  bindFunctions () {
    this.togglePanel = this.togglePanel.bind(this)
  }

  bindEvents () {
    this.$.on('click', '[aria-controls]', this.togglePanel)
  }

  togglePanel (e) {
    const $panel = $(e.currentTarget)

    if ($panel.attr('aria-expanded') === 'true') {
      $panel.attr('aria-expanded', 'false')
      $panel.next().attr('aria-hidden', 'true').slideUp()
    } else {
      $panel.attr('aria-expanded', 'true')
      $panel.next().attr('aria-hidden', 'false').slideDown()
    }
  }
}

window.customElements.define('flynt-accordion-default', AccordionDefault, { extends: 'div' })
