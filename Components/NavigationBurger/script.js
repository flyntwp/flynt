import $ from 'jquery'
import { disableBodyScroll, enableBodyScroll } from 'body-scroll-lock'

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
  }

  bindFunctions () {
    this.triggerMenu = this.triggerMenu.bind(this)
  }

  bindEvents () {
    this.$.on('click', '[data-toggle-menu]', this.triggerMenu)
  }

  resolveElements () {
    this.$container = $('.container', this)
    this.$menu = $('.menu', this)
  }

  connectedCallback () {}

  triggerMenu (e) {
    this.$container.toggleClass('container-menuIsOpen')
    if (this.$container.hasClass('container-menuIsOpen')) {
      disableBodyScroll(this.$menu.get(0))
    } else {
      enableBodyScroll(this.$menu.get(0))
    }
  }
}

window.customElements.define('flynt-navigation-burger', NavigationBurger, {
  extends: 'nav'
})
