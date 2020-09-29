import $ from 'jquery'

class BlockAnchor extends window.HTMLDivElement {
  constructor (...args) {
    const self = super(...args)
    self.init()
    return self
  }

  init () {
    this.$ = $(this)
    this.resolveElements()
  }

  resolveElements () {
  }

  connectedCallback () {
  }
}

window.customElements.define('flynt-block-anchor', BlockAnchor, { extends: 'div' })
