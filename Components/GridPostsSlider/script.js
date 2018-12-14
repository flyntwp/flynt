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
  }

  connectedCallback () {
    $('.gridPosts-wrapper').slick({
      infinite: true,
      slidesToShow: 3,
      slidesToScroll: 3,
      arrows: false,
      dots: true,
      responsive: [
        {
          breakpoint: 1025,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
            infinite: true,
            arrows: true,
            dots: true
          }
        },
        {
          breakpoint: 700,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false
          }
        }
      ]
    })
  }
}

window.customElements.define('flynt-grid-posts-slider', GridPostsSlider, { extends: 'div' })
