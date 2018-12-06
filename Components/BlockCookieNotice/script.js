/* globals Cookies */
import $ from 'jquery'
import 'file-loader?name=vendor/js-cookie.js!uglify-loader!js-cookie/src/js.cookie.js'

class BlockCookieNotice extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.setOptions()
    self.resolveElements()
    return self
  }

  setOptions () {
    this.cookieName = 'cookieNoticeSeen'
    this.expiryDays = 365
  }

  resolveElements () {
    this.$btnClose = $('.btnClose', this)
  }

  connectedCallback () {
    this.checkCookie()
    this.$.on('click', this.$btnClose.selector, this.close.bind(this))
  }

  checkCookie () {
    if (typeof Cookies.get(this.cookieName) === 'undefined') {
      this.$.show()
    }
  }

  close (e) {
    e.preventDefault()
    Cookies.set(this.cookieName, true, { expires: this.expiryDays })
    this.$.slideUp()
  }
}

window.customElements.define('flynt-block-cookie-notice', BlockCookieNotice, {extends: 'div'})
