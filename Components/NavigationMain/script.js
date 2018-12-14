import $ from 'jquery'

class NavigationMain extends window.HTMLElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.resolveElements()
    return self
  }

  resolveElements () {
    this.enableTransition = this.enableTransition.bind(this)
    this.triggerMenu = this.triggerMenu.bind(this)
    this.$hamburger = $('.hamburger', this)
    this.$navigation = $('.navigationMain', this)
    this.$body = $('body')
    this.$menu = $('.menu', this)
    this.noTransitionClass = 'menu-hasNoTransition'
  }

  connectedCallback () {
    this.$.on('click', '.hamburger', this.triggerMenu)
    $(window).on('resize', () => {
      this.disableTransition()
      clearTimeout(this.enableTransitionTimeout)
      this.enableTransitionTimeout = setTimeout(this.enableTransition, 150)
    })
  }

  disableTransition () {
    this.$menu.addClass(this.noTransitionClass)
  }

  enableTransition () {
    this.$menu.removeClass(this.noTransitionClass)
  }

  triggerMenu (e) {
    e.preventDefault()
    this.$navigation.toggleClass('navigationMain-isActive')
    this.$body.toggleClass('navigationMain-isActive')
  }
}

window.customElements.define('flynt-navigation-main', NavigationMain, { extends: 'nav' })
