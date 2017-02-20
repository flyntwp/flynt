class MediaTextBlock extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.resolveElements()
    return self
  }

  resolveElements () {
    this.$imageWrapper = $('.mediaTextBlock-imageWrapper', this)
    this.$video = $('.mediaTextBlock-oembedVideo', this)
    this.$iframe = $('iframe', this)
  }

  connectedCallback () {
    this.$posterImage.on('click', (e) => {
      this.startVideo()
    })
  }

  startVideo = () => {
    this.$iframe.attr('src', this.$iframe.data('src'))
    this.$posterImage.addClass('mediaTextBlock-imageWrapper-isHidden')
    this.$video.addClass('mediaTextBlock-oembedVideo-isVisible')
  }
}

window.customElements.define('flynt-media-text-block', MediaTextBlock, {extends: 'div'})
