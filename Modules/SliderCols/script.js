// name=[location in our vendor folder] ! [location in package folder]
import 'file-loader?name=vendor/normalize.css!normalize.css/normalize.css'
// Webpack looks for dist file in package "main".
import 'file-loader?name=vendor/slick.js!slick-carousel'
import 'file-loader?name=vendor/slick.css!slick-carousel/slick/slick.css'
import 'file-loader?name=vendor/jquery-throttle-debounce.js!jquery-throttle-debounce/jquery.ba-throttle-debounce'

function importSlickFonts (fontName) { // eslint-disable-line no-unused-vars
  require(`file-loader?name=vendor/slick/[name].[ext]!slick-carousel/slick/fonts/${fontName}`)
}

class SliderCols extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.sliderInitialised = false
    self.isMobile = false
    self.resolveElements()
    return self
  }

  resolveElements () {
    this.$slider = $('.slider-row', this)
  }

  connectedCallback () {
    this.setupSlider()
    $(window).on('resize', $.debounce(300, this.setupSlider))
  }

  setupSlider = () => {
    if ($(window).width() < 800) {
      this.isMobile = true
      if (!this.sliderInitialised) {
        this.sliderInitialised = true
        this.$slider.slick()
      }
    } else {
      this.isMobile = false
      if (this.sliderInitialised) {
        this.sliderInitialised = false
        this.$slider.slick('unslick')
      }
    }
  }
}

window.customElements.define('wps-slider-cols', SliderCols, {extends: 'div'})
