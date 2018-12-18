import $ from 'jquery'
import 'file-loader?name=vendor/slick.js!slick-carousel/slick/slick.min'
import 'file-loader?name=vendor/slick.css!csso-loader!slick-carousel/slick/slick.css'

class GridPostsSlider extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.resolveElements()
    return self
  }

  resolveElements () {
    this.$gridPostsSlider = $('.gridPosts', this)
  }

  connectedCallback () {
    this.$gridPostsSlider.slick({
      infinite: true,
      slidesToShow: 4,
      arrows: true,
      dots: false,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 2,
            arrows: false,
            dots: true
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            arrows: false,
            dots: true
          }
        }
      ]
    })
  }
}

window.customElements.define('flynt-grid-posts-slider', GridPostsSlider, { extends: 'div' })
