import $ from 'jquery'
import Cookies from 'js-cookie'

const $document = $(document)

class FeatureGoogleAnalytics extends window.HTMLDivElement {
  constructor (...args) {
    window.$ = window.jQuery
    const self = super(...args)
    self.init()
    return self
  }

  init () {
    this.$ = $(this)
    this.props = this.getInitialProps()
    this.resolveElements()
    this.bindFunctions()
    this.bindEvents()
  }

  getInitialProps () {
    let data = {}
    try {
      data = JSON.parse($('script[type="application/json"]', this).text())
    } catch (e) {
      console.log(e)
    }
    return data
  }

  resolveElements () {
    this.gaId = this.props.gaId ? this.props.gaId : false
    this.disableStr = 'ga-disable-' + this.props.gaId
  }

  bindFunctions () {
    this.trackingChanged = this.trackingChanged.bind(this)
    this.onOptOut = this.onOptOut.bind(this)
  }

  bindEvents () {
    $('body').on('click', '[data-action="gaOptOut"]', this.trackingChanged)
  }

  connectedCallback () {
    window[this.disableStr] = this.isOptedOut()
    if (this.props.isOptInComponentRegistered) {
      $document.on('trackingChanged', this.trackingChanged)
    } else {
      this.defineGlobalGAFunction()
    }
  }

  removeFunctionsAndAddFallback () {
    this.addGTAGFunctionFallback()
  }

  isOptedOut () {
    return Cookies.get(this.disableStr) === 'true'
  }

  setOptedOut (optedOut) {
    window[this.disableStr] = optedOut
    Cookies.set(this.disableStr, optedOut)
    this.defineGlobalGAFunction()
  }

  trackingChanged (event, trackingObject = {}) {
    const optedOut = !trackingObject.GA_accept
    this.setOptedOut(optedOut)
  }

  defineGlobalGAFunction () {
    let gtag
    if (this.isOptedOut()) {
      gtag = function () { }
    } else if (this.gaId === 'debug') {
      gtag = function () {
        console.log('GoogleAnalytics', [].slice.call(arguments))
      }
    } else {
      this.loadGAScript()
      window.dataLayer = window.dataLayer || []
      gtag = function () {
        window.dataLayer.push(arguments)
      }
    }
    window.gtag = gtag
    this.initGA()
  }

  loadGAScript () {
    if (!this.gaLoaded) {
      this.gaLoaded = true
      const scriptUrl = `https://www.googletagmanager.com/gtag/js?id=${this.gaId}`
      $.getScript(scriptUrl)
    }
  }

  initGA () {
    if (!this.gaInitialized) {
      this.gaInitialized = true
      const { gtag } = window
      gtag('js', new Date())
      gtag('config', this.gaId, { anonymize_ip: this.props.anonymizeIp })
    }
  }

  onOptOut (e) {
    e.preventDefault()
    this.setOptedOut(true)
  }
}

window.customElements.define('flynt-google-analytics', FeatureGoogleAnalytics, { extends: 'div' })
