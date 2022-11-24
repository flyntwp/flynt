import Swiper, { Navigation, A11y, Autoplay, Lazy } from 'swiper'
import 'swiper/css/bundle'

export default function (el) {
  new SliderImages(el)
}

class SliderImages {
  constructor (el) {
    this.element = el
    this.init()
    this.connectedCallback()
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
      modules: [Navigation, A11y, Lazy, Autoplay],
      a11y: options.a11y,
      roundLengths: true,
      navigation: {
        nextEl: this.buttonNext,
        prevEl: this.buttonPrev
      },
      lazy: {
        loadPrevNext: true
      }
    }
    if (options.autoplay && options.autoplaySpeed) {
      config.autoplay = {
        delay: options.autoplaySpeed
      }
    }

    this.swiper = new Swiper(this.slider, config)
  }

  querySelector (...args) {
    return this.element.querySelector(...args)
  }
}
