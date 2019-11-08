import $ from 'jquery'
import Cookies from 'js-cookie'

class BlockCookieNotice extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.setOptions()
    self.resolveElements()
    self.bindFunctions()
    self.bindEvents()
    return self
  }

  setOptions () {
    this.cookieName = 'acceptedTracking'
    this.exipiryDays = 99
  }

  resolveElements () {
    this.$acceptButton = $('[data-accept]', this)
    this.$declineButton = $('[data-decline]', this)
    this.$optOutLink = $('.trackingOptOutLink')
  }

  bindFunctions () {
    this.acceptTracking = this.acceptTracking.bind(this)
    this.declineTracking = this.declineTracking.bind(this)
    this.showCookieNotice = this.showCookieNotice.bind(this)
    this.hideCookieNotice = this.hideCookieNotice.bind(this)
  }
  bindEvents () {
    this.$.on('click', '[data-accept]', this.acceptTracking)
    this.$.on('click', '[data-decline]', this.declineTracking)
    this.$optOutLink.on('click', this.showCookieNotice)
  }

  connectedCallback () {
    if (typeof Cookies.get(this.cookieName) === 'undefined') {
      this.showCookieNotice()
    }
    window.showModalFromConsole = this.showCookieNotice
  }

  showCookieNotice (e = false) {
    if (e) {
      e.preventDefault()
    }
    this.$.addClass('cookieNotice--isVisible')
  }

  hideCookieNotice (e = false) {
    if (e) {
      e.preventDefault()
    }
    this.$.removeClass('cookieNotice--isVisible')
  }

  acceptTracking () {
    Cookies.set(this.cookieName, true, { expires: Number(this.exipiryDays) })
    this.hideCookieNotice()
    $.publish('trackingChanged', true)
  }

  declineTracking () {
    Cookies.set(this.cookieName, false, { expires: Number(this.exipiryDays) })
    this.hideCookieNotice()
    $.publish('trackingChanged', false )
  }
}

window.customElements.define('flynt-block-cookie-notice', BlockCookieNotice, { extends: 'div' })
