import $ from 'jquery'

class ListTestimorialsCards extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.resolveElements()
    return self
  }

  resolveElements () {
  }

  connectedCallback () {
  }
}

window.customElements.define('flynt-list-testimorials-cards', ListTestimorialsCards, {extends: 'div'})
