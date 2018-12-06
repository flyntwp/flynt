import $ from 'jquery'

class ListTitleTextList extends window.HTMLDivElement {
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

window.customElements.define('flynt-list-title-text-list', ListTitleTextList, {extends: 'div'})
