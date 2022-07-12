import Swiper, { Navigation, A11y, Autoplay } from 'swiper'
import 'swiper/css/bundle'

class SliderImages extends window.HTMLDivElement {
  constructor (...args) {
    const self = super(...args)
    self.init()
    return self
  }

  init () {
    this.props = this.getInitialProps()
    this.resolveElements()
  }

  getInitialProps () {
    let data = {}
    try {
      data = JSON.parse(this.querySelector('script[type="application/json"]').textContent)
    } catch (e) {}
    return data
  }

  resolveElements () {
    this.slider = this.querySelector('[data-slider]')
    this.buttonNext = this.querySelector('[data-slider-button="next"]')
    this.buttonPrev = this.querySelector('[data-slider-button="prev"]')
  }

  connectedCallback () {
    this.initSlider()
  }

  initSlider () {
    const { options } = this.props
    const config = {
      modules: [Navigation, A11y, Autoplay],
      navigation: {
        nextEl: this.buttonNext,
        prevEl: this.buttonPrev
      },
      a11y: options.a11y
    }
    if (options.autoplay && options.autoplaySpeed) {
      config.autoplay = {
        delay: options.autoplaySpeed
      }
    }

    this.swiper = new Swiper(this.slider, config)
  }
}

window.customElements.define('flynt-slider-images', SliderImages, { extends: 'div' })
