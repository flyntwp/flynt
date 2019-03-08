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
    this.$componentScreenshotWrappers = $('.component-screenshotWrapper', this)
    this.$componentScreenshotImages = $('.component-screenshotWrapper img', this)
  }

  connectedCallback () {
    if (this.$window.width() > 575) {
      this.$.on('mouseenter mouseleave', this.$componentScreenshotWrappers.selector, this.toggleHoverScroll.bind(this))
    } else {
      this.$window.on('resize', this.setParallaxConfig.bind(this))
      $(document).on('lazyloaded', this.setParallaxConfig.bind(this))
      this.$window.on('scroll', this.startParallaxScroll.bind(this))
    }
  }

  toggleHoverScroll (e) {
    let $screenshotWrapper = $(e.currentTarget)
    let $screenshotWrapperHeight = $screenshotWrapper.outerHeight()
    let $image = $screenshotWrapper.find('img')
    let $imageHeight = $image.height()

    if ($imageHeight > $screenshotWrapperHeight) {
      if (e.type === 'mouseenter') {
        $image.css('transition', 'transform ' + (($imageHeight - $screenshotWrapperHeight) / $screenshotWrapperHeight) + 's cubic-bezier(0.215, 0.61, 0.355, 1)')
        $image.css('transform', 'translateY(-' + ($imageHeight - $screenshotWrapperHeight) + 'px)')
      } else {
        $image.css('transition', 'transform ' + (($imageHeight - $screenshotWrapperHeight) / $screenshotWrapperHeight) + 's cubic-bezier(0.23, 1, 0.32, 1)')
        $image.css('transform', 'translateY(0)')
      }
    }
  }

  setParallaxConfig () {
    let windowHeight = this.$window.height()

    this.$componentScreenshotImages.each((index, el) => {
      let $image = $(el)
      let $screenshotWrapper = $image.parent()

      let imageOverflow = $image.height() - $screenshotWrapper.outerHeight()
      let topOffset = $screenshotWrapper.offset().top
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

    this.$componentScreenshotImages.each((index, el) => {
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

window.customElements.define('flynt-list-components', ListComponents, { extends: 'div' })
