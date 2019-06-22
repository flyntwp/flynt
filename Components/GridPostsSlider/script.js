import $ from 'jquery'
import Swiper from 'swiper'
import 'swiper/dist/css/swiper.min.css'

class GridPostsSlider extends window.HTMLDivElement {
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
    this.$pagination = $('[data-slider-pagination]', this)
  }

  connectedCallback () {
    this.initSlider()
  }

  initSlider () {
    const { options } = this.props
    const config = {
      a11y: options.a11y,
      spaceBetween: 23,
      pagination: {
        el: this.$pagination,
        clickable: true
      },
      slidesPerView: 4,
      breakpoints: {
        480: {
          slidesPerView: 1
        },
        768: {
          slidesPerView: 2
        },
        1024: {
          slidesPerView: 3
        }
      }
    }

    if (options.autoplay && options.autoplaySpeed) {
      config['autoplay'] = {
        delay: options.autoplaySpeed
      }
    }

    this.swiper = new Swiper(this.$slider, config)
  }
}

window.customElements.define('flynt-grid-posts-slider', GridPostsSlider, { extends: 'div' })
