import $ from 'jquery'
import 'core-js/es/object/assign'
import 'core-js/es/object/keys'
import Headroom from 'headroom.js'
import debounce from 'lodash/debounce'

class NavigationMain extends window.HTMLElement {
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
    this.onWindowResize = this.onWindowResize.bind(this)
  }

  bindEvents () {
    $(window).on('resize', debounce(this.onWindowResize, 200))
  }

  resolveElements () {}

  connectedCallback () {
    this.initHeadroom()
  }

  initHeadroom () {
    this.headroom = new Headroom(this, {
      offset: 80,
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
