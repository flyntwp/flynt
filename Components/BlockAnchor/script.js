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
  }

  bindEvents () {
    $('body').on('click', 'a[href*="#"]', this.scrollToAnchor)
  }

  connectedCallback () {
    this.$window.on('load', () => {
      this.scrollToHash()
    })
  }

  scrollToAnchor (e) {
    e.preventDefault()
    const href = $(e.target).attr('href')

    if (href) {
      const hash = href.split('#')[1]
      if (hash) {
        this.scrollTo(hash)
      }
    }
  }

  scrollToHash () {
    const hash = window.location.hash.substring(1)
    if (hash) {
      setTimeout(() => {
        this.scrollTo(hash)
      }, 500)
    }
  }

  scrollTo (target) {
    const $target = $(`#${target}`)
    if ($target.length) {
      $('html, body').animate({
        scrollTop: $target.offset().top
      }, 500, 'easeOutQuad')
    }
  }
}

window.customElements.define('flynt-block-anchor', BlockAnchor, { extends: 'div' })
