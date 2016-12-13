class MediaTextBlock extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.resolveElements()
    return self
  }

  resolveElements () {
    this.$posterImage = $('.mediaTextBlock-oembedPosterImage', this)
    this.$video = $('.mediaTextBlock-oembedVideo', this)
    this.$iframe = $('iframe', this)
  }

  connectedCallback () {
    this.$posterImage.on('click', (e) => {
      this.startVideo()
    })
  }

  startVideo = () => {
    this.$video.attr('src', this.$video.data('src'))
    this.$posterImage.addClass('isHidden')
    this.$video.addClass('isActive')
  }
}

window.customElements.define('wps-media-text-block', MediaTextBlock, {extends: 'div'})
