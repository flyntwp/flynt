import $ from 'jquery'

class ListComponents extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.resolveElements()
    return self
  }

  resolveElements () {
    this.animating = []
    this.$components = $('.component-desktopImageWrapper, .component-mobileImageWrapper', this)
  }

  connectedCallback () {
    this.$.on('mouseover', this.$components.selector, this.previewScroll.bind(this))
    this.$.on('mouseout', this.$components.selector, this.stopPreviewScroll.bind(this))
  }

  previewScroll (e) {
    console.log('scroll')
    let $imageWrapper = $(e.currentTarget)
    let $image = $imageWrapper.find('.image')
    if ($image.height() > $imageWrapper.height()) {
      $image.css('transition', 'transform ' + 0.01 * ($image.height() - $imageWrapper.height()) + 's cubic-bezier(0.165, 0.84, 0.44, 1)')
      $image.css('transform', 'translateY(-' + ($image.height() - $imageWrapper.height()) + 'px)')
    }
  }

  stopPreviewScroll (e) {
    let $imageWrapper = $(e.currentTarget)
    let $image = $imageWrapper.find('.image')
    if ($image.height() > $imageWrapper.height()) {
      $image.css('transition', 'transform ' + 0.01 * ($image.height() - $imageWrapper.height()) + 's cubic-bezier(0.165, 0.84, 0.44, 1)')
      $image.css('transform', 'translateY(0)')
    }
  }
}

window.customElements.define('flynt-list-components', ListComponents, {extends: 'div'})
