// name=[location in our vendor folder] ! [location in package folder]
import 'file-loader?name=vendor/normalize.css!normalize.css/normalize.css'
// Webpack looks for dist file in package "main".
import 'file-loader?name=vendor/slick.js!slick-carousel'
import 'file-loader?name=vendor/slick.css!slick-carousel/slick/slick.css'

function importSlickFonts (fontName) { // eslint-disable-line no-unused-vars
  require(`file-loader?name=vendor/slick/[name].[ext]!slick-carousel/slick/fonts/${fontName}`)
}

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
    $(window).on('resize', $.debounce(300, this.setupSlider))
  }

  setupSlider = () => {
    this.$mediaSlides.slick()
    // if ($(window).width() < 800) {
    //   this.isMobile = true
    //
    // } else {
    //   this.isMobile = false
    //   if (this.sliderInitialised) {
    //     this.sliderInitialised = false
    //     this.$mediaSlides.slick('unslick')
    //   }
    // }
  }
}

window.customElements.define('wps-media-slider', MediaSlider, {extends: 'div'})
