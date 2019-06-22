import Rellax from 'rellax'
import $ from 'jquery'

let rellax

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
    if (!rellax) {
      rellax = new Rellax('[data-parallax]', {
        speed: 2,
        center: true,
        percentage: 0.5
      })
    }
  }

}

window.customElements.define('flynt-block-image-text-parallax', BlockImageTextParallax, { extends: 'div' })
