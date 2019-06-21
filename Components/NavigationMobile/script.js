import $ from 'jquery'

class NavigationMobile extends window.HTMLElement {
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
    this.$body = $('body')
  }

  connectedCallback () {}

  triggerMenu (e) {
    this.$container.toggleClass('container-isActive')
    this.$body.toggleClass('navigationMobile-isActive')
  }
}

window.customElements.define('flynt-navigation-mobile', NavigationMobile, {
  extends: 'nav'
})
