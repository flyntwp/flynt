import Rellax from 'rellax'
import $ from 'jquery'

const $window = $(window)

let rellax, initialized

class BlockImageTextParallax extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    return self
  }

  connectedCallback () {
    initParallax()
  }
}

function initParallax () {
  if (!initialized) {
    initialized = true
    setParallax()
    $window.on('resize', setParallax)
  }
}

function setParallax () {
  if (isMobile()) {
    if (rellax) {
      rellax.destroy()
      rellax = false
    }
  } else {
    if (!rellax && !isMobile()) {
      rellax = new Rellax('[data-parallax]', {
        speed: 2,
        center: true,
        percentage: 0.5
      })
    } else if (rellax) {
      rellax.refresh()
    }
  }
}

function isMobile () {
  return window.matchMedia('(max-width: 1023px)').matches
}

window.customElements.define('flynt-block-image-text-parallax', BlockImageTextParallax, { extends: 'div' })
