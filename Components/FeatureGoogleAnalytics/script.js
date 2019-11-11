import $ from 'jquery'
import Cookies from 'js-cookie'

const $document = $(document)

class FeatureGoogleAnalytics extends window.HTMLDivElement {
  constructor(self){
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
    this.$acceptButton = $('[data-accept]', this)
    this.$declineButton = $('[data-decline]', this)
    this.gaId = this.props.gaId ? this.props.gaId : false
    this.serverSideTrackingEnabled = this.props.serverSideTrackingEnabled ? this.props.serverSideTrackingEnabled : false
    this.disableStr = 'ga-disable-' + this.props.gaId
  }

  bindFunctions () {
    this.addGTAGFunction = this.addGTAGFunction.bind(this)
    this.addGTAGFunctionFallback = this.addGTAGFunctionFallback.bind(this)
    this.addGTAGScript = this.addGTAGScript.bind(this)
    this.trackingChanged = this.trackingChanged.bind(this)
  }

  connectedCallback () {
    if (this.props.isOptInComponentRegistered) {
      $document.on('trackingChanged', this.trackingChanged)
      this.addGTAGFunctionFallback()
    } else {
      if(!this.GTAGscriptElement){
        this.addGTAGScript()
      }
      this.addGTAGFunction()
    }
  }

  trackingChanged (event, trackingObject) {
    if(typeof trackingObject.GA_accept !== 'undefined' && trackingObject.GA_accept && this.gaId && this.serverSideTrackingEnabled){
      window[this.disableStr] = false
      Cookies.remove(this.disableStr)
      if(!this.GTAGscriptElement){
        this.addGTAGScript()
      }
      this.addGTAGFunction()
    }else{
      window[this.disableStr] = true
      Cookies.set(this.disableStr, true)
      if(this.GTAGscriptElement){
        this.GTAGscriptElement.remove()
      }
      this.addGTAGFunctionFallback()
    }
  }


  addGTAGScript () {
    const scriptUrl = `https://www.googletagmanager.com/gtag/js?id=${this.gaId}`
    this.GTAGscriptElement = document.createElement('script')
    this.GTAGscriptElement.async = true
    this.GTAGscriptElement.type = 'text/javascript'
    this.GTAGscriptElement.src = scriptUrl
    document.head.appendChild(this.GTAGscriptElement)
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
  }
}

window.customElements.define('flynt-google-analytics', FeatureGoogleAnalytics, { extends: 'div' })