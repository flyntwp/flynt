import $ from 'jquery'
import Cookies from 'js-cookie'

class GoogleAnalyticsOptIn extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.props = self.getInitialProps()
    self.setOptions()
    self.resolveElements()
    self.bindFunctions()
    self.bindEvents()
    return self
  }

  setOptions () {
    this.cookieName = 'acceptedTracking'
  }

  getInitialProps () {
    let data = {}
    try {
      data = JSON.parse($('script[type="application/json"]', this).text())
    } catch (e) {}
    return data
  }

  resolveElements () {
    this.$acceptButton = $('[data-accept]', this)
    this.$declineButton = $('[data-decline]', this)
    this.gaId = this.isValidId(this.props.gaId) ? this.props.gaId : false
    this.disableStr = 'ga-disable-' + this.props.gaId
  }

  bindFunctions () {
    this.addGTAGFunction = this.addGtagFunction.bind(this)
    this.addGTAGFunctionFallback = this.addGtagFunctionFallback.bind(this)
    this.addGTAGScript = this.addGtagScript.bind(this)
    this.acceptTracking = this.acceptTracking.bind(this)
    this.declineTracking = this.declineTracking.bind(this)
    this.showModal = this.showModal.bind(this)
    this.hideModal = this.hideModal.bind(this)
  }

  bindEvents () {
    this.$acceptButton.on('click', this.acceptTracking)
    this.$declineButton.on('click', this.declineTracking)
    $(document.body).on('click', '.googleOptOutLink', this.showModal)
  }

  connectedCallback () {
    this.checkOptState()
    window.showModalFromConsole = this.showModal
  }

  addGtagScript () {
    const scriptUrl = `https://www.googletagmanager.com/gtag/js?id=${this.gaId}`
    this.GTAGscriptElement = document.createElement('script')
    this.GTAGscriptElement.async = true
    this.GTAGscriptElement.type = 'text/javascript'
    this.GTAGscriptElement.src = scriptUrl
    document.head.appendChild(this.GTAGscriptElement)
  }

  addGtagFunction () {
    window.dataLayer = window.dataLayer || []
    window.gtag = function () {
      window.dataLayer.push(arguments)
    }
    window.gtag('js', new Date())
    window.gtag('config', this.gaId, { anonymize_ip: true })
  }

  addGtagFunctionFallback () {
    window.gtag = function () {
      console.log('GoogleAnalytics: ' + [].slice.call(arguments))
    }
  }

  isValidId (gaId) {
    if (gaId === 'debug') {
      return true
    } else {
      return /^ua-\d{4,9}-\d{1,4}$/i.test(gaId)
    }
  }

  checkOptState () {
    if (typeof Cookies.get(this.cookieName) === 'undefined') {
      this.showModal()
    }
    const getCookieValue = Cookies.get(this.cookieName) ? Cookies.get(this.cookieName) : 'false'
    if (this.gaId) {
      if (getCookieValue === 'false') {
        Cookies.set(this.disableStr, true)
        window[this.disableStr] = true
        this.addGtagFunctionFallback()
      } else {
        this.acceptTracking()
        Cookies.remove(this.disableStr)
        window[this.disableStr] = false
      }
    }
  }

  acceptTracking () {
    Cookies.set(this.cookieName, true, { expires: Number(this.props.expiryDays), path: window.location.pathname })
    this.hideModal()
    if (this.gaId) {
      window[this.disableStr] = false
      Cookies.remove(this.disableStr)
      if (this.props.serverSideTrackingEnabled === true) {
        this.addGtagScript()
        this.addGtagFunction()
      }
    }
  }

  declineTracking () {
    Cookies.set(this.cookieName, false, { expires: Number(this.props.expiryDays), path: window.location.pathname })
    this.hideModal()
    if (this.gaId) {
      Cookies.set(this.disableStr, true)
      window[this.disableStr] = true
      if (typeof this.GTAGscriptElement !== 'undefined') {
        this.GTAGscriptElement.remove()
      }
      this.addGtagFunctionFallback()
    }
  }

  showModal () {
    this.$.addClass('cookieNotice--isVisible')
  }

  hideModal () {
    this.$.removeClass('cookieNotice--isVisible')
  }
}

window.customElements.define('flynt-google-analytics-opt-in', GoogleAnalyticsOptIn, { extends: 'div' })
