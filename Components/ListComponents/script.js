class ListComponents extends window.HTMLDivElement {
  constructor (...args) {
    const self = super(...args)
    self.init()
    return self
  }

  init () {
    this.resolveElements()
    this.bindFunctions()
  }

  resolveElements () {
    this.window = window
    this.document = document
    this.componentScreenshotImages = this.querySelectorAll('.component-imageWrapper img')
  }

  bindFunctions () {
    this.toggleHoverScroll = this.toggleHoverScroll.bind(this)
    this.setParallaxConfig = this.setParallaxConfig.bind(this)
    this.startParallaxScroll = this.startParallaxScroll.bind(this)
  }

  connectedCallback () {
    if (!this.isDesktop()) {
      // Add delegated events.
      this.addEventListener('mouseenter', (e) => {
        const { target } = e
        if (target.matches('.component-link')) {
          this.toggleHoverScroll(e)
        }
      }, true)

      this.addEventListener('mouseleave', (e) => {
        const { target } = e
        if (target.matches('.component-link')) {
          this.toggleHoverScroll(e)
        }
      }, true)
    } else {
      this.window.addEventListener('resize', this.setParallaxConfig)
      this.document.addEventListener('lazyloaded', this.setParallaxConfig)
      this.window.addEventListener('scroll', this.startParallaxScroll, { passive: true })
    }
  }

  toggleHoverScroll (e) {
    const imageWrapper = e.target.querySelector('.component-imageWrapper')
    const imageWrapperHeight = imageWrapper.offsetHeight
    const image = imageWrapper.querySelector('img')
    const imageHeight = image.offsetHeight

    if (imageHeight > imageWrapperHeight) {
      if (e.type === 'mouseenter') {
        image.style.transition = 'transform ' + Math.max(((imageHeight - imageWrapperHeight) / imageWrapperHeight), 0.3) + 's cubic-bezier(0.215, 0.61, 0.355, 1)'
        image.style.transform = 'translateY(-' + (imageHeight - imageWrapperHeight) + 'px)'
      } else {
        image.style.transition = 'transform ' + Math.max(((imageHeight - imageWrapperHeight) / imageWrapperHeight), 0.3) + 's cubic-bezier(0.23, 1, 0.32, 1)'
        image.style.transform = 'translateY(0)'
      }
    }
  }

  setParallaxConfig (e) {
    const windowHeight = this.window.innerHeight
    console.log(e.type)

    this.componentScreenshotImages.forEach((image) => {
      const imageWrapper = image.parentElement

      const imageOverflow = image.offsetHeight - imageWrapper.offsetHeight
      const topOffset = imageWrapper.getBoundingClientRect().top
      const startOffset = topOffset - windowHeight * 0.4
      const endOffset = topOffset - 100

      if (!image.dataset.parallaxConfig) {
        image.dataset.parallaxConfig = JSON.stringify({
          imageOverflow,
          startOffset,
          endOffset
        })
      }
    })

    this.startParallaxScroll()
  }

  startParallaxScroll (e) {
    const scrollTop = window.scrollY

    this.componentScreenshotImages.forEach((image) => {
      const parallaxConfig = JSON.parse(image.dataset.parallaxConfig)

      if (parallaxConfig && parallaxConfig.imageOverflow > 0) {
        let scrollPercentage = (scrollTop - parallaxConfig.startOffset) / (parallaxConfig.endOffset - parallaxConfig.startOffset)
        scrollPercentage = Math.min(Math.max(scrollPercentage, 0), 1)
        const move = (scrollPercentage * parallaxConfig.imageOverflow) * -1
        if (!e || (scrollTop >= parallaxConfig.startOffset && scrollTop < parallaxConfig.endOffset)) {
          image.style.transform = 'translateY(' + move + 'px)'
        }
      }
    })
  }

  isDesktop () {
    return window.matchMedia('(max-width: 1280px)').matches
  }
}

window.customElements.define('flynt-list-components', ListComponents, { extends: 'div' })
