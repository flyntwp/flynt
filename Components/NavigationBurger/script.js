import $ from 'jquery'
import { disableBodyScroll, enableBodyScroll } from 'body-scroll-lock'
import Headroom from 'headroom.js'
import debounce from 'lodash/debounce'

class NavigationBurger extends window.HTMLElement {
  constructor (...args) {
    const self = super(...args)
    self.init()
    return self
  }

  init () {
    this.$ = $(this)
    this.bindFunctions()
    this.bindEvents()
    this.resolveElements()
    this.headroom = null
  }

  bindFunctions () {
    this.triggerMenu = this.triggerMenu.bind(this)
    this.onWindowResize = this.onWindowResize.bind(this)
  }

  bindEvents () {
    this.$.on('click', '[data-toggle-menu]', this.triggerMenu)
    $(window).on('resize', debounce(this.onWindowResize, 200))
  }

  resolveElements () {
    this.$menu = $('.menu', this)
    this.$menuButton = $('.hamburger', this)
  }

  connectedCallback () {
    this.initHeadroom()
  }

  triggerMenu (e) {
    this.$.toggleClass('flyntComponent-menuIsOpen')
    this.$menuButton.attr('aria-expanded', this.$menuButton.attr('aria-expanded') === 'false' ? 'true' : 'false')
    if (this.$.hasClass('flyntComponent-menuIsOpen')) {
      disableBodyScroll(this.$menu.get(0))
    } else {
      enableBodyScroll(this.$menu.get(0))
    }
  }

  initHeadroom () {
    this.headroom = new Headroom(this, {
      offset: 64,
      tolerance: {
        up: 5,
        down: 0
      }
    })

    if (this.isMobile()) {
      this.headroom.init()
    }
  }

  onWindowResize () {
    if (this.isMobile()) {
      if (!this.headroom.initialised) this.headroom.init()
    } else {
      if (this.headroom.initialised) this.headroom.destroy()
    }
  }

  isMobile () {
    return window.matchMedia('(max-width: 1023px)').matches
  }
}

window.customElements.define('flynt-navigation-burger', NavigationBurger, {
  extends: 'nav'
})
