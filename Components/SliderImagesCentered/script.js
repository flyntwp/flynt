import $ from 'jquery'
import Swiper from 'swiper'
import 'swiper/dist/css/swiper.min.css'

class SliderImagesCentered extends window.HTMLDivElement {
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
    this.$pagination = $('.slider-pagination', this)
  }

  connectedCallback () {
    this.initSlider()
  }

  initSlider () {
    const { sliderOptions } = this.props

    this.swiper = new Swiper(this.$slider, {
      a11y: sliderOptions.a11y,
      centeredSlides: true,
      loop: true,
      navigation: {
        nextEl: this.$buttonNext,
        prevEl: this.$buttonPrev
      },
      pagination: {
        el: this.$pagination,
        clickable: true,
      },
      slidesPerView: 'auto',
      spaceBetween: 20
    })
  }
}

window.customElements.define('flynt-slider-images-centered', SliderImagesCentered, { extends: 'div' })
