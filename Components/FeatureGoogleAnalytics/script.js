import $ from 'jquery'
import Cookies from 'js-cookie'

const $document = $(document)

class FeatureGoogleAnalytics extends window.HTMLDivElement {
  constructor (self) {
    window.$ = window.jQuery
    self = super(self)
    self.$ = window.$(self)
    self.props = self.getInitialProps()
    self.resolveElements()
    self.bindFunctions()
    return self
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
    this.isTrackingEnabled = this.props.isTrackingEnabled ? this.props.isTrackingEnabled : false
    this.disableStr = 'ga-disable-' + this.props.gaId
  }

  bindFunctions () {
    this.trackingChanged = this.trackingChanged.bind(this)
  }

  connectedCallback () {
    const alreadyAccepted = this.checkIfAlreadyAccepted()
    if (!alreadyAccepted) {
      if (this.props.isOptInComponentRegistered) {
        $document.on('trackingChanged', this.trackingChanged)
      } else {
        this.addFunctions()
      }
    }
  }

  addFunctions () {
    this.addGTAGScript()
    if (this.gaId === 'debug') {
      this.addGTAGFunctionFallback()
    } else {
      this.addGTAGFunction()
    }
  }

  removeFunctionsAndAddFallback () {
    this.addGTAGFunctionFallback()
  }

  checkIfAlreadyAccepted () {
    if (this.gaId === 'debug' || Cookies.get(this.disableStr) === 'false') {
      this.addFunctions()
      return true
    }
    return false
  }

  trackingChanged (event, trackingObject = {}) {
    if (this.gaId === 'debug' || (trackingObject.GA_accept && this.gaId)) {
      window[this.disableStr] = false
      Cookies.set(this.disableStr, false)
      this.addFunctions()
    } else {
      window[this.disableStr] = true
      Cookies.set(this.disableStr, true)
      this.removeFunctionsAndAddFallback()
    }
  }

  addGTAGScript () {
    if (this.scriptLoaded) {
      return
    }
    this.scriptLoaded = true
    const scriptUrl = `https://www.googletagmanager.com/gtag/js?id=${this.gaId}`
    const GTAGscriptElement = document.createElement('script')
    GTAGscriptElement.async = true
    GTAGscriptElement.type = 'text/javascript'
    GTAGscriptElement.src = scriptUrl
    document.head.appendChild(GTAGscriptElement)
  }

  addGTAGFunction () {
    window.dataLayer = window.dataLayer || []
    window.gtag = function () {
      window.dataLayer.push(arguments)
    }
    window.gtag('js', new Date())
    window.gtag('config', this.gaId, { anonymize_ip: this.props.anonymizeIp })
  }

  addGTAGFunctionFallback () {
    window.gtag = function () {
      console.log('GoogleAnalytics: ' + [].slice.call(arguments))
    }
    window.gtag('js', new Date())
    window.gtag('config', this.gaId, { anonymize_ip: this.props.anonymizeIp })
  }
}

window.customElements.define('flynt-google-analytics', FeatureGoogleAnalytics, { extends: 'div' })
