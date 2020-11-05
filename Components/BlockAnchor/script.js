/* globals location */
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
    this.$document = $(document)
    this.$body = $('body')
  }

  bindFunctions () {
    this.checkScrollToLink = this.checkScrollToLink.bind(this)
    this.checkScrollToHash = this.checkScrollToHash.bind(this)
  }

  bindEvents () {
    $('body').off('click').on('click', 'a[href*="#"]', this.checkScrollToLink)
  }

  connectedCallback () {
    if (window.location.hash && !(this.$body.hasClass('scrolledToHash'))) {
      this.$body.addClass('scrolledToHash')
      this.$window.on('load', this.checkScrollToHash)
    }
  }

  checkScrollToLink (e) {
    const $el = $(e.currentTarget)
    const href = $(e.currentTarget).attr('href')
    /* detect local link */
    if (location.hostname === $el.prop('hostname') || !$el.prop('hostname').length) {
      /* detect hash in link */
      if (href.indexOf('#') !== -1) {
        this.smoothScrollTo(href.substr(href.indexOf('#')))
      }
    }
  }

  checkScrollToHash () {
    const hash = window.location.hash
    if (hash) {
      setTimeout(() => {
        this.smoothScrollTo(hash)
      }, 500)
    }
  }

  smoothScrollTo (hash) {
    const $target = $(hash)
    if ($target.length) {
      let offsetTop = $target.offset().top
      const maxScrollOffsetTop = this.$document.height() - this.$window.height()
      offsetTop = $target.offset().top
      offsetTop = offsetTop >= maxScrollOffsetTop ? maxScrollOffsetTop : offsetTop
      // calculate speed based on travel distance
      const maxtime = 3000
      const distance = Math.abs(offsetTop - this.$window.scrollTop())
      const ratio = distance / this.$document.height()
      const speed = maxtime * ratio

      $('html, body').stop().animate({
        scrollTop: offsetTop
      }, speed, 'easeInOutQuart')
    }
  }
}

window.customElements.define('flynt-block-anchor', BlockAnchor, { extends: 'div' })
