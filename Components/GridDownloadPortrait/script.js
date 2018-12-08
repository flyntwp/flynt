import $ from 'jquery'

class GridDownloadPortrait extends window.HTMLDivElement {
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

window.customElements.define('flynt-grid-download-portrait', GridDownloadPortrait, {extends: 'div'})
