import $ from 'jquery'

class AccordionDefault extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    return self
  }

  connectedCallback () {
    this.$.on('click', '[aria-controls]', this.togglePanel)
  }

  togglePanel () {
    const $panel = $(this)
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
