import $ from 'jquery'

class ListComponents extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.resolveElements()
    return self
  }

  resolveElements () {
    this.$window = $(window)
    this.$componentImageWrappers = $('.component-previewImage', this)
    this.$componentImageMobile = $('.component-previewImage img', this)
  }

  connectedCallback () {
    if (this.$window.width() > 575) {
      this.$.on('mouseenter mouseleave', this.$componentImageWrappers.selector, this.toggleHoverScroll.bind(this))
    } else {
      this.$window.on('resize', this.setParallaxConfig.bind(this))
      $(document).on('lazyloaded', this.setParallaxConfig.bind(this))
      this.$window.on('scroll', this.startParallaxScroll.bind(this))
    }
  }

  toggleHoverScroll (e) {
    let $imageWrapper = $(e.currentTarget)
    let $imageWrapperHeight = $imageWrapper.outerHeight()
    let $image = $imageWrapper.find('img')
    let $imageHeight = $image.height()

    if ($imageHeight > $imageWrapperHeight) {
      if (e.type === 'mouseenter') {
        $image.css('transition', 'transform ' + (($imageHeight - $imageWrapperHeight) / $imageWrapperHeight) + 's cubic-bezier(0.215, 0.61, 0.355, 1)')
        $image.css('transform', 'translateY(-' + ($imageHeight - $imageWrapperHeight) + 'px)')
      } else {
        $image.css('transition', 'transform ' + (($imageHeight - $imageWrapperHeight) / $imageWrapperHeight) + 's cubic-bezier(0.23, 1, 0.32, 1)')
        $image.css('transform', 'translateY(0)')
      }
    }
  }

  setParallaxConfig () {
    let windowHeight = this.$window.height()

    this.$componentImageMobile.each((index, el) => {
      let $image = $(el)
      let $imageWrapper = $image.parent()
      let $previewWrapper = $image.closest('.component-previews')

      let imageOverflow = $image.height() - $imageWrapper.outerHeight()
      let topOffset = $previewWrapper.offset().top
      let startOffset = topOffset - windowHeight * 0.4
      let endOffset = topOffset - 100

      $image.data('parallaxConfig', {
        imageOverflow: imageOverflow,
        startOffset: startOffset,
        endOffset: endOffset
      })
    })

    this.startParallaxScroll()
  }

  startParallaxScroll (e) {
    let scrollTop = this.$window.scrollTop()

    this.$componentImageMobile.each((index, el) => {
      let $image = $(el)
      let parallaxConfig = $image.data('parallaxConfig')

      if (parallaxConfig && parallaxConfig.imageOverflow > 0) {
        let scrollPercentage = (scrollTop - parallaxConfig.startOffset) / (parallaxConfig.endOffset - parallaxConfig.startOffset)
        scrollPercentage = Math.min(Math.max(scrollPercentage, 0), 1)
        let move = (scrollPercentage * parallaxConfig.imageOverflow) * -1
        if (!e || (scrollTop >= parallaxConfig.startOffset && scrollTop < parallaxConfig.endOffset)) {
          $image.css('transform', 'translateY(' + move + 'px)')
        }
      }
    })
  }
}

window.customElements.define('flynt-list-components', ListComponents, {extends: 'div'})
