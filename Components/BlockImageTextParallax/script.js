/* globals Rellax */

import Rellax from 'rellax'
import $ from 'jquery'

class BlockImageTextParallax extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.resolveElements()
    return self
  }

  resolveElements () {

  }

  connectedCallback () {
    var rellax = new Rellax('.rellax', {

    })
  }
}

window.customElements.define('flynt-block-image-text-parallax', BlockImageTextParallax, { extends: 'div' })
