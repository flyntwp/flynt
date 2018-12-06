import $ from 'jquery'

class ListSearchResults extends window.HTMLDivElement {
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

window.customElements.define('flynt-list-search-results', ListSearchResults, {extends: 'div'})
