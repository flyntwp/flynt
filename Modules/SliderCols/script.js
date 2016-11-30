import 'file-loader?name=vendor/normalize.css!normalize.css/normalize.css'
import 'file-loader?name=vendor/slick.js!slick-carousel'
import 'file-loader?name=vendor/slick.css!slick-carousel/slick/slick.css'

function importSlickFonts (fontName) { // eslint-disable-line no-unused-vars
  require(`file-loader?name=vendor/slick/[name].[ext]!slick-carousel/slick/fonts/${fontName}`)
}

$(window).on('load', function () {
  $('.slider-row').slick()
})

// class SliderCols extends window.HTMLDivElement {
//   constructor (self) {
//     self = super(self)
//     self.$ = $(self)
//     this.resolveElements()
//     return self
//   }
//
//   resolveElements () {
//     this.$slider = window.jQuery('.slider-row', this)
//   }
//
//   connectedCallback () {
//     this.$slider.slick()
//     // $(window).on('load', () => {
//     //   console.log(window.jQuery.fn.slick)
//     //   console.log(this.$slider)
//     //
//     // })
//   }
// }
//
// window.customElements.define('wps-slider-cols', SliderCols, {extends: 'div'})
