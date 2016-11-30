import 'file-loader?name=vendor/normalize.css!normalize.css/normalize.css'
import 'file-loader?name=vendor/slick.js!slick-carousel'
import 'file-loader?name=vendor/slick.css!slick-carousel/slick/slick.css'

function importSlickFonts (fontName) { // eslint-disable-line no-unused-vars
  require(`file-loader?name=vendor/slick/[name].[ext]!slick-carousel/slick/fonts/${fontName}`)
}

class SliderCols extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    // self.addEventListener('click', console.log)
    // important in case you create instances procedurally:
    // var me = new MyElement()
    console.log('construct...')
    self.$ = $(self)
    return self
  }

  $$ (selector) {
    return $(selector, this)
  }

  connectedCallback () {
    console.log('connected')
  }
}

window.customElements.define('wps-slider-cols', SliderCols, {extends: 'div'})
