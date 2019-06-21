import $ from 'jquery'
import Swiper from 'swiper'
import 'swiper/dist/css/swiper.min.css'

class SliderImages extends window.HTMLDivElement {
  constructor (...args) {
    const self = super(...args)
    self.init()
    return self
  }

  init () {
    this.$ = $(this)
    this.props = this.getInitialProps()
    this.resolveElements()
  }

  getInitialProps () {
    let data = {}
    try {
      data = JSON.parse($('script[type="application/json"]', this).text())
    } catch (e) {}
    return data
  }

  resolveElements () {
    this.$slider = $('.slider', this)
    this.$buttonNext = $('.slider-button--next', this)
    this.$buttonPrev = $('.slider-button--prev', this)
  }

  connectedCallback () {
    this.initSlider()
  }

  initSlider () {
    const { sliderOptions } = this.props

    this.slider = new Swiper(this.$slider, {
      navigation: {
        nextEl: this.$buttonNext,
        prevEl: this.$buttonPrev
      },
      a11y: sliderOptions.a11y
    })
  }
}

window.customElements.define('flynt-slider-images', SliderImages, { extends: 'div' })
