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
    this.data = JSON.parse(this.$.children('[data-is=componentData]').first().html()) || {}
    this.cookieName = 'cookieNoticeSeen'
  }

  resolveElements () {
    this.$closeBtn = $('.btn-close', this)
    this.checkCookie()
  }

  connectedCallback () {
    this.$.on('click', this.$closeBtn.selector, this.close.bind(this))
  }

  checkCookie () {
    if (typeof Cookies.get(this.cookieName) === 'undefined') {
      this.show()
    }
  }

  show () {
    this.$.show()
  }

  close (e) {
    e.preventDefault()
    Cookies.set(this.cookieName, true, { expires: this.data.expiryDays })
    this.$.slideUp()
  }
}

window.customElements.define('flynt-block-cookie-notice', BlockCookieNotice, {extends: 'div'})
