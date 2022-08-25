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
    this.resolveElements()
    this.bindFunctions()
    this.bindEvents()
    this.headroom = null
    this.isMenuOpen = false
  }

  bindFunctions () {
    this.triggerMenu = this.triggerMenu.bind(this)
    this.onWindowResize = this.onWindowResize.bind(this)
  }

  bindEvents () {
    this.menuButton.addEventListener('click', this.triggerMenu)
    this.window.addEventListener('resize', debounce(this.onWindowResize, 200))
  }

  resolveElements () {
    this.window = window
    this.menu = this.querySelector('.menu')
    this.menuButton = this.querySelector('.hamburger')
    this.navigationHeight = parseInt(window.getComputedStyle(this).getPropertyValue('--navigation-height')) || 0
  }

  connectedCallback () {
    this.initHeadroom()
  }

  triggerMenu (e) {
    this.isMenuOpen = !this.isMenuOpen
    this.menuButton.setAttribute('aria-expanded', this.isMenuOpen)

    if (this.isMenuOpen) {
      this.setAttribute('data-status', 'menuIsOpen')
      disableBodyScroll(this.menu)
    } else {
      this.removeAttribute('data-status')
      enableBodyScroll(this.menu)
    }
  }

  initHeadroom () {
    const navigationHeight = parseInt(window.getComputedStyle(this).getPropertyValue('--navigation-height')) || 0

    this.headroom = new Headroom(this, {
      offset: navigationHeight,
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
