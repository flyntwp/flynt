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
    this.$componentScreenshotWrappers = $('.component-screenshotWrapper', this)
    this.$componentScreenshotImages = $('.component-screenshotWrapper img', this)
  }

  bindFunctions () {
    this.toggleHoverScroll = this.toggleHoverScroll.bind(this)
    this.setParallaxConfig = this.setParallaxConfig.bind(this)
    this.startParallaxScroll = this.startParallaxScroll.bind(this)
  }

  connectedCallback () {
    if (this.$window.width() > 575) {
      this.$.on('mouseenter mouseleave', '.component-screenshotWrapper', this.toggleHoverScroll)
    } else {
      this.$window.on('resize', this.setParallaxConfig)
      this.$document.on('lazyloaded', this.setParallaxConfig)
      this.$window.on('scroll', this.startParallaxScroll)
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
