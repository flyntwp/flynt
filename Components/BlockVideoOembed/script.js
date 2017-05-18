import $ from 'jquery'

class BlockVideoOembed extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.resolveElements()
    return self
  }

  resolveElements () {
    this.$posterImage = $('.oembedVideo-posterImage', this)
    this.$video = $('.oembedVideo-video', this)
    this.$iframe = $('iframe', this)
  }

  connectedCallback () {
    this.$iframe.on('load', this.onIframeLoad)
    this.$.on('click', this.$posterImage.selector, this.setIframeSrc)
  }

  setIframeSrc = () => {
    this.$iframe.attr('src', this.$iframe.data('src'))
  }

  onIframeLoad = () => {
    this.$video.addClass('oembedVideo-video-isVisible')
    this.$posterImage.addClass('oembedVideo-posterImage-isHidden')
  }
}

window.customElements.define('flynt-block-video-oembed', BlockVideoOembed, {extends: 'div'})
