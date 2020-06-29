import $ from 'jquery'
import Swiper from 'swiper'
import 'swiper/css/swiper.min.css'

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
    this.$slider = $('[data-slider]', this)
    this.$buttonNext = $('[data-slider-button="next"]', this)
    this.$buttonPrev = $('[data-slider-button="prev"]', this)
  }

  connectedCallback () {
    this.initSlider()
  }

  initSlider () {
    const { options } = this.props
    const config = {
      navigation: {
        nextEl: this.$buttonNext,
        prevEl: this.$buttonPrev
      },
      a11y: options.a11y,
      keyboard: true,
    }
    if (options.autoplay && options.autoplaySpeed) {
      config.autoplay = {
        delay: options.autoplaySpeed
      }
    }
    this.slider = new Swiper(this.$slider, config)
  }
}

window.customElements.define('flynt-slider-images', SliderImages, { extends: 'div' })
