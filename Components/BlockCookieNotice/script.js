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
  }

  resolveElements () {
    this.$acceptButton = $('[data-accept]', this)
    this.$declineButton = $('[data-decline]', this)
    this.$optOutLink = $('.trackingOptOutLink')
  }

  bindFunctions () {
    // this.addGTAGFunction = this.addGTAGFunction.bind(this)
    // this.addGTAGFunctionFallback = this.addGTAGFunctionFallback.bind(this)
    // this.addGTAGScript = this.addGTAGScript.bind(this)
    this.acceptTracking = this.acceptTracking.bind(this)
    this.declineTracking = this.declineTracking.bind(this)
    this.showCookieNotice = this.showCookieNotice.bind(this)
    this.hideCookieNotice = this.hideCookieNotice.bind(this)
  }
  bindEvents () {
    this.$.on('click', '[data-accept]', this.acceptTracking)
    this.$.on('click', '[data-decline]', this.declineTracking)
    this.$optOutLink.on('click', this.showModal)
  }

  connectedCallback () {
    console.log(this.$declineButton)
    console.log('connectedcallback')
    //console.log(Cookies.get(this.cookieName))
    if (typeof Cookies.get(this.cookieName) === 'undefined') {
      this.showCookieNotice()
    }
  }

  showCookieNotice (e = false) {
    if (e) {
      e.preventDefault()
    }
    this.$.addClass('cookieNotice--isVisible')
  }

  hideCookieNotice (e) {
    if (e) {
      e.preventDefault()
    }
    this.$.removeClass('cookieNotice--isVisible')
  }

  acceptTracking () {
    Cookies.set(this.cookieName, true, { expires: Number(this.props.expiryDays), path: window.location.pathname })
    this.hideCookieNotice()
    $.publish('trackingChanged', { accepted: true })

    // if (this.gaId) {
    //   window[this.disableStr] = false
    //   Cookies.remove(this.disableStr)
    //   if (this.props.serverSideTrackingEnabled === true) {
    //     this.addGTAGScript()
    //     this.addGTAGFunction()
    //   }
    // }
  }

  declineTracking () {
    Cookies.set(this.cookieName, false, { expires: Number(this.props.expiryDays), path: window.location.pathname })
    this.hideModal()
    $.publish('trackingChanged', { accepted: false })

    // if (this.gaId) {
    //   Cookies.set(this.disableStr, true)
    //   window[this.disableStr] = true
    //   if (typeof this.GTAGscriptElem !== 'undefined') {
    //     this.GTAGscriptElem.remove()
    //   }
    //   if (typeof this.GTAGscriptElemFunction !== 'undefined') {
    //     this.GTAGscriptElemFunction.remove()
    //   }
    //   this.addGTAGFunctionFallback()
    // }
  }

  checkOptState () {
    // if (typeof this.GTAGscriptElemFunctionFallback === 'undefined') {
    //   this.addGTAGFunctionFallback()
    // }
    if (typeof Cookies.get(this.cookieName) === 'undefined') {
      this.showModal()
    }
    // const getCookieValue = Cookies.get(this.cookieName) ? Cookies.get(this.cookieName) : 'false'
    // if (this.gaId) {
    //   if (getCookieValue === 'false') {
    //     Cookies.set(this.disableStr, true)
    //     window[this.disableStr] = true
    //   } else {
    //     this.acceptTracking()
    //     Cookies.remove(this.disableStr)
    //     window[this.disableStr] = false
    //   }
    // }
  }
}

window.customElements.define('flynt-block-cookie-notice', BlockCookieNotice, { extends: 'div' })
