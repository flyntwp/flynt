import $ from 'jquery'
import 'slick-carousel'
import 'file-loader?name=vendor/slick.css!csso-loader!slick-carousel/slick/slick.css'

class SliderImageGallery extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.resolveElements()
    self.setOptions()
    return self
  }

  resolveElements () {
    this.$sliderMain = $('.slider-main', this)
    this.$sliderThumb = $('.slider-thumb', this)
  }

  setOptions () {
    this.slickMainOptions = {
      arrows: true,
      asNavFor: this.$sliderThumb.selector,
      dots: false,
      focusOnChange: false,
      infinite: false,
      responsive: [
        {
          breakpoint: 768,
          settings: {
            arrows: false
          }
        }
      ]
    }
    this.slickThumbOptions = {
      arrows: false,
      asNavFor: this.$sliderMain.selector,
      centerMode: true,
      dots: false,
      draggable: false,
      focusOnChange: false,
      focusOnSelect: true,
      infinite: false,
      swipeToSlide: true,
      variableWidth: true
    }
  }

  connectedCallback () {
    this.$sliderMain.not('.slick-initialized').slick(this.slickMainOptions)
    this.$sliderThumb.not('.slick-initialized').slick(this.slickThumbOptions)
  }
}

window.customElements.define('flynt-slider-image-gallery', SliderImageGallery, { extends: 'div' })
