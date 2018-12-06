import $ from 'jquery'
import 'file-loader?name=vendor/lazysizes-object-fit.js!uglify-loader!lazysizes/plugins/object-fit/ls.object-fit'
import 'file-loader?name=vendor/lazysizes-parent-fit.js!uglify-loader!lazysizes/plugins/parent-fit/ls.parent-fit'
import 'file-loader?name=vendor/lazysizes.js!uglify-loader!lazysizes'

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
