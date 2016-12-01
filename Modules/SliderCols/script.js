// name=[location in our vendor folder] ! [location in package folder]
import 'file-loader?name=vendor/normalize.css!normalize.css/normalize.css'
import 'file-loader?name=vendor/slick.js!slick-carousel' // Webpack magic.
import 'file-loader?name=vendor/slick.css!slick-carousel/slick/slick.css'

function importSlickFonts (fontName) { // eslint-disable-line no-unused-vars
  require(`file-loader?name=vendor/slick/[name].[ext]!slick-carousel/slick/fonts/${fontName}`)
}

class SliderCols extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    this.resolveElements()
    return self
  }

  resolveElements () {
    this.$slider = $('.slider-row', this)
  }

  connectedCallback () {
    if ($(window).width() < 800) {
      this.$slider.slick()
    }
  }
}

window.customElements.define('wps-slider-cols', SliderCols, {extends: 'div'})
