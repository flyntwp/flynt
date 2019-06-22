import $ from 'jquery'
import Swiper from 'swiper'
import 'swiper/dist/css/swiper.min.css'

class SliderImageGallery extends window.HTMLDivElement {
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
    this.$sliderMain = $('.sliderMain', this)
    this.$sliderThumb = $('.sliderThumb', this)
    this.$buttonNext = $('.sliderMain-button--next', this)
    this.$buttonPrev = $('.sliderMain-button--prev', this)
  }

  connectedCallback () {
    this.initSliders()
  }

  initSliders () {
    const { options } = this.props

    this.sliderThumb = new Swiper(this.$sliderThumb, {
      slidesPerView: 'auto',
      freeMode: true,
      centeredSlides: true,
      slideToClickedSlide: true,
      a11y: options.a11y
    })

    this.sliderMain = new Swiper(this.$sliderMain, {
      spaceBetween: 10,
      navigation: {
        nextEl: this.$buttonNext,
        prevEl: this.$buttonPrev,
      },
      a11y: options.a11y
    })

    this.sliderMain.controller.control = this.sliderThumb
    this.sliderThumb.controller.control = this.sliderMain
  }
}

window.customElements.define('flynt-slider-image-gallery', SliderImageGallery, { extends: 'div' })
