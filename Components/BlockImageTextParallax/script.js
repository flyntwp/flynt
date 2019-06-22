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
    // this.$parallax = $('[data-parallax]', this)
    // this.$mainContent = $('.mainContent', this)
    // this.$window = $(window)
  }

  connectedCallback () {
    // this.setParallax()

    // this.$window.on('resize', this.setParallax.bind(this))
    // this.onElementHeightChange(this.$mainContent.get(0), () => {
    //   if (this.rellax) {
    //     this.rellax.refresh()
    //   }
    // })
  }

  // onElementHeightChange (elm, callback) {
  //   let lastHeight = elm.clientHeight
  //   let newHeight

  //   (function run () {
  //     newHeight = elm.clientHeight
  //     if (lastHeight !== newHeight) {
  //       callback()
  //     }
  //     lastHeight = newHeight

  //     if (elm.onElementHeightChangeTime) {
  //       clearTimeout(elm.onElementHeightChangeTimer)
  //     }

  //     elm.onElementHeightChangeTimer = setTimeout(run, 200)
  //   })()
  // }

  // setParallax () {
  //   if (this.isMobile()) {
  //     if (this.rellax) {
  //       this.rellax.destroy()
  //       this.rellax = false
  //     }
  //   } else {
  //     if (!this.rellax && $('[data-parallax]', this).length) {
  //       this.rellax = new Rellax('[data-parallax]', {
  //         speed: 2,
  //         center: true,
  //         percentage: 0.5
  //       })
  //     }
  //   }
  // }

  // isMobile () {
  //   return window.matchMedia('(max-width: 1199px)').matches
  // }
}

window.customElements.define('flynt-block-image-text-parallax', BlockImageTextParallax, { extends: 'div' })
