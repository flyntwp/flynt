import $ from 'jquery'

class AccordionDefault extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.resolveElements()
    return self
  }

  resolveElements () {
    this.$accordionTriggers = $('[aria-controls]', this)
  }

  connectedCallback () {
    this.$.on('click', this.$accordionTriggers.selector, this.togglePanel)
  }

  togglePanel () {
    let $this = $(this)
    if ($this.attr('aria-expanded') === 'true') {
      $this.attr('aria-expanded', 'false')
      $this.next().attr('aria-hidden', 'true').slideUp()
    } else {
      $this.attr('aria-expanded', 'true')
      $this.next().attr('aria-hidden', 'false').slideDown()
    }
  }
}

window.customElements.define('flynt-accordion-default', AccordionDefault, { extends: 'div' })
