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
    this.$optOutLink = $('.googleOptOutLink')
    this.gaId = this.isValidId(this.props.gaId) ? this.props.gaId : false
    this.disableStr = 'ga-disable-' + this.props.gaId
  }

  bindFunctions () {
    this.addGTAGFunction = this.addGTAGFunction.bind(this)
    this.addGTAGFunctionFallback = this.addGTAGFunctionFallback.bind(this)
    this.addGTAGScript = this.addGTAGScript.bind(this)
    this.acceptTracking = this.acceptTracking.bind(this)
    this.declineTracking = this.declineTracking.bind(this)
    this.showModal = this.showModal.bind(this)
    this.hideModal = this.hideModal.bind(this)
  }

  bindEvents () {
    this.$acceptButton.on('click', this.acceptTracking)
    this.$declineButton.on('click', this.declineTracking)
    this.$optOutLink.on('click', this.showModal)
  }

  connectedCallback () {
    this.checkOptState()
  }

  addGTAGScript () {
    const scriptUrl = `https://www.googletagmanager.com/gtag/js?id=${this.gaId}`
    this.GTAGscriptElem = document.createElement('script')
    this.GTAGscriptElem.async = true
    this.GTAGscriptElem.type = 'text/javascript'
    this.GTAGscriptElem.src = scriptUrl
    document.head.appendChild(this.GTAGscriptElem)
  }

  addGTAGFunction () {
    const scriptContent = `window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', '${this.gaId}', { 'anonymize_ip': true });`
    this.GTAGscriptElemFunction = document.createElement('script')
    this.GTAGscriptElemFunction.type = 'text/javascript'
    this.GTAGscriptElemFunction.text = scriptContent
    document.head.appendChild(this.GTAGscriptElemFunction)
  }

  addGTAGFunctionFallback () {
    const scriptContent = `function gtag() {
      console.log('GoogleAnalytics: ' + [].slice.call(arguments));
    }`
    this.GTAGscriptElemFunctionFallback = document.createElement('script')
    this.GTAGscriptElemFunctionFallback.type = 'text/javascript'
    this.GTAGscriptElemFunctionFallback.text = scriptContent
    document.head.appendChild(this.GTAGscriptElemFunctionFallback)
  }

  isValidId (gaId) {
    if (gaId === 'debug') {
      return true
    } else {
      return /^ua-\d{4,9}-\d{1,4}$/i.test(gaId)
    }
  }

  checkOptState () {
    if (typeof this.GTAGscriptElemFunctionFallback === 'undefined') {
      this.addGTAGFunctionFallback()
    }
    if (typeof Cookies.get(this.cookieName) === 'undefined') {
      this.showModal()
    }
    const getCookieValue = Cookies.get(this.cookieName) ? Cookies.get(this.cookieName) : 'false'
    if (this.gaId) {
      if (getCookieValue === 'false') {
        Cookies.set(this.disableStr, true)
        window[this.disableStr] = true
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
        this.addGTAGScript()
        this.addGTAGFunction()
      }
    }
  }

  declineTracking () {
    Cookies.set(this.cookieName, false, { expires: Number(this.props.expiryDays), path: window.location.pathname })
    this.hideModal()
    if (this.gaId) {
      Cookies.set(this.disableStr, true)
      window[this.disableStr] = true
      if (typeof this.GTAGscriptElem !== 'undefined') {
        this.GTAGscriptElem.remove()
      }
      if (typeof this.GTAGscriptElemFunction !== 'undefined') {
        this.GTAGscriptElemFunction.remove()
      }
      this.addGTAGFunctionFallback()
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
