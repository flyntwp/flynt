// name=[location in our vendor folder] ! [location in package folder]
import 'file-loader?name=vendor/normalize.css!normalize.css/normalize.css'
// Webpack looks for dist file in package "main".
import 'file-loader?name=vendor/slick.js!slick-carousel'
import 'file-loader?name=vendor/slick.css!slick-carousel/slick/slick.css'

function importSlickFonts (fontName) { // eslint-disable-line no-unused-vars
  require(`file-loader?name=vendor/slick/[name].[ext]!slick-carousel/slick/fonts/${fontName}`)
}

import slickConfiguration from './sliderConfiguration.js'

class MediaSlider extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.sliderInitialised = false
    self.isMobile = false
    self.resolveElements()
    return self
  }

  resolveElements () {
    this.$mediaSlides = $('.mediaSlider-slides', this)
  }

  connectedCallback () {
    this.setupSlider()
  }

  setupSlider = () => {
    this.$mediaSlides.slick(slickConfiguration)
  }
}

window.customElements.define('wps-media-slider', MediaSlider, {extends: 'div'})
