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
    $(window).on('load resize orientationchange', function () {
      $('.gridPosts').each(function () {
        var $carousel = $(this)
        if ($(window).width() > 1100) {
          if ($carousel.hasClass('slick-initialized')) {
            $carousel.slick('unslick')
          }
        } else {
          if (!$carousel.hasClass('slick-initialized')) {
            $carousel.slick({
              arrows: false,
              dots: true,
              mobileFirst: true,
              slidesToShow: 1,
              slidesToScroll: 1,
              responsive: [
                {
                  breakpoint: 600,
                  settings: {
                    slidesToShow: 1
                  }
                },
                {
                  breakpoint: 768,
                  settings: {
                    slidesToShow: 2
                  }
                },
                {
                  breakpoint: 991,
                  settings: {
                    slidesToShow: 3
                  }
                }
              ]
            })
          }
        }
      })
    })
  }
}

window.customElements.define('flynt-grid-posts-slider', GridPostsSlider, { extends: 'div' })
