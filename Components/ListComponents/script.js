import $ from 'jquery'

class ListComponents extends window.HTMLDivElement {
  constructor (...args) {
    const self = super(...args)
    self.init()
    return self
  }

  init () {
    this.$ = $(this)
    this.resolveElements()
    this.bindFunctions()
  }

  resolveElements () {
    this.$window = $(window)
    this.$document = $(document)
    this.$componentimageWrappers = $('.component-imageWrapper', this)
    this.$componentScreenshotImages = $('.component-imageWrapper img', this)
  }

  bindFunctions () {
    this.toggleHoverScroll = this.toggleHoverScroll.bind(this)
    this.setParallaxConfig = this.setParallaxConfig.bind(this)
    this.startParallaxScroll = this.startParallaxScroll.bind(this)
  }

  connectedCallback () {
    if (this.$window.width() >= 1280) {
      this.$.on('mouseenter mouseleave', '.component-link', this.toggleHoverScroll)
    } else {
      this.$window.on('resize', this.setParallaxConfig)
      this.$document.on('lazyloaded', this.setParallaxConfig)
      this.$window.on('scroll', this.startParallaxScroll)
    }
  }

  toggleHoverScroll (e) {
    const $imageWrapper = $(e.currentTarget).find('.component-imageWrapper')
    const $imageWrapperHeight = $imageWrapper.outerHeight()
    const $image = $imageWrapper.find('img')
    const $imageHeight = $image.height()

    if ($imageHeight > $imageWrapperHeight) {
      if (e.type === 'mouseenter') {
        $image.css('transition', 'transform ' + Math.max((($imageHeight - $imageWrapperHeight) / $imageWrapperHeight), 0.3) + 's cubic-bezier(0.215, 0.61, 0.355, 1)')
        $image.css('transform', 'translateY(-' + ($imageHeight - $imageWrapperHeight) + 'px)')
      } else {
        $image.css('transition', 'transform ' + Math.max((($imageHeight - $imageWrapperHeight) / $imageWrapperHeight), 0.3) + 's cubic-bezier(0.23, 1, 0.32, 1)')
        $image.css('transform', 'translateY(0)')
      }
    }
  }

  setParallaxConfig () {
    const windowHeight = this.$window.height()

    this.$componentScreenshotImages.each((index, el) => {
      const $image = $(el)
      const $imageWrapper = $image.parent()

      const imageOverflow = $image.height() - $imageWrapper.outerHeight()
      const topOffset = $imageWrapper.offset().top
      const startOffset = topOffset - windowHeight * 0.4
      const endOffset = topOffset - 100

      $image.data('parallaxConfig', {
        imageOverflow: imageOverflow,
        startOffset: startOffset,
        endOffset: endOffset
      })
    })

    this.startParallaxScroll()
  }

  startParallaxScroll (e) {
    const scrollTop = this.$window.scrollTop()

    this.$componentScreenshotImages.each((index, el) => {
      const $image = $(el)
      const parallaxConfig = $image.data('parallaxConfig')

      if (parallaxConfig && parallaxConfig.imageOverflow > 0) {
        let scrollPercentage = (scrollTop - parallaxConfig.startOffset) / (parallaxConfig.endOffset - parallaxConfig.startOffset)
        scrollPercentage = Math.min(Math.max(scrollPercentage, 0), 1)
        const move = (scrollPercentage * parallaxConfig.imageOverflow) * -1
        if (!e || (scrollTop >= parallaxConfig.startOffset && scrollTop < parallaxConfig.endOffset)) {
          $image.css('transform', 'translateY(' + move + 'px)')
        }
      }
    })
  }
}

window.customElements.define('flynt-list-components', ListComponents, { extends: 'div' })
