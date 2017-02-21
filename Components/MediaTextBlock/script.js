// TODO: hide poster after video is succesfully loaded

class MediaTextBlock extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.resolveElements()
    return self
  }

  resolveElements () {
    this.$posterImage = $('.mediaTextBlock-posterImage', this)
    this.$video = $('.mediaTextBlock-video', this)
    this.$iframe = $('iframe', this)
  }

  connectedCallback () {
    this.$posterImage.on('click', (e) => {
      this.startVideo()
    })
  }

  startVideo = () => {
    this.$iframe.attr('src', this.$iframe.data('src'))
    this.$video.addClass('mediaTextBlock-video-isVisible')
    this.$posterImage.addClass('mediaTextBlock-posterImage-isHidden')
  }
}

window.customElements.define('flynt-media-text-block', MediaTextBlock, {extends: 'div'})
