import Headroom from 'headroom.js'
import debounce from 'lodash/debounce'

class NavigationMain extends window.HTMLElement {
  constructor (...args) {
    const self = super(...args)
    self.init()
    return self
  }

  init () {
    this.bindFunctions()
    this.bindEvents()
    this.headroom = null
  }

  bindFunctions () {
    this.onWindowResize = this.onWindowResize.bind(this)
  }

  bindEvents () {
    window.addEventListener('resize', debounce(this.onWindowResize, 200))
  }

  connectedCallback () {
    this.initHeadroom()
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

    if (!this.isMobile()) {
      this.headroom.init()
    }
  }

  onWindowResize () {
    if (!this.isMobile()) {
      if (!this.headroom.initialised) this.headroom.init()
    } else {
      if (this.headroom.initialised) this.headroom.destroy()
    }
  }

  isMobile () {
    return window.matchMedia('(max-width: 1023px)').matches
  }
}

window.customElements.define('flynt-navigation-main', NavigationMain, {
  extends: 'nav'
})
