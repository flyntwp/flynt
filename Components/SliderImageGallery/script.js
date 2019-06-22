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
    this.$sliderMain = $('[data-slider="main"]', this)
    this.$sliderThumb = $('[data-slider="thumb"]', this)
    this.$buttonNext = $('[data-slider-button="next"]', this)
    this.$buttonPrev = $('[data-slider-button="prev"]', this)
  }

  connectedCallback () {
    this.initSliders()
  }

  initSliders () {
    const { options } = this.props

    this.sliderThumb = new Swiper(this.$sliderThumb, {
      spaceBetween: 10,
      slidesPerView: 'auto',
      freeMode: true,
      centeredSlides: true,
      slideToClickedSlide: true,
      a11y: options.a11y
    })

    this.sliderMain = new Swiper(this.$sliderMain, {
      navigation: {
        nextEl: this.$buttonNext,
        prevEl: this.$buttonPrev
      },
      controller: {
        control: this.sliderThumb
      },
      a11y: options.a11y
    })

    this.sliderThumb.controller.control = this.sliderMain
  }
}

window.customElements.define('flynt-slider-image-gallery', SliderImageGallery, { extends: 'div' })
