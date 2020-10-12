import $ from 'jquery'
import 'jquery.easing'

class BlockAnchor extends window.HTMLDivElement {
  constructor (...args) {
    const self = super(...args)
    self.init()
    return self
  }

  init () {
    this.$ = $(this)
    this.resolveElements()
    this.bindFunctions()
    this.bindEvents()
  }

  resolveElements () {
    this.$window = $(window)
  }

  bindFunctions () {
    this.scrollToAnchor = this.scrollToAnchor.bind(this)
    this.blockJump = this.blockJump.bind(this)
  }

  bindEvents () {
    $('body').on('click', 'a[href*="#"]', this.scrollToAnchor)
  }

  connectedCallback () {
    if (window.location.hash) {
      this.$window.on('load', this.scrollToAnchor)
    }
  }

  blockJump () {
    return setTimeout(() => window.scrollTo(0, 0), 1)
  }

  scrollToAnchor (e) {
    const $target = window.location.hash ? $(window.location.hash) : $(e.target).attr('href')
    if ($target.length > 0) {
      this.blockJump()
      $('html, body').animate({
        scrollTop: $target.offset().top
      }, 500, 'easeOutQuad')
    }
  }
}

window.customElements.define('flynt-block-anchor', BlockAnchor, { extends: 'div' })
