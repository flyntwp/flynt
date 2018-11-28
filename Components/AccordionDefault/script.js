import $ from 'jquery'

class AccordionDefault extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.resolveElements()
    return self
  }

  resolveElements () {
    this.$accordionTriggers = $('.panel-trigger', this)
  }

  connectedCallback () {
    this.$.on('click', this.$accordionTriggers.selector, this.togglePanel)
  }

  togglePanel () {
    let $this = $(this)
    if ($this.attr('aria-expanded') === 'true') {
      $this.attr('aria-expanded', 'false')
      $this.next().slideUp('slow').attr('aria-hidden', 'true')
    } else {
      $this.attr('aria-expanded', 'true')
      $this.next().slideDown('slow').attr('aria-hidden', 'false')
    }
  }
}

window.customElements.define('flynt-accordion-default', AccordionDefault, {extends: 'div'})
