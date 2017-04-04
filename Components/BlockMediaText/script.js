// TODO: hide poster after video is succesfully loaded

class BlockMediaText extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.resolveElements()
    return self
  }

  resolveElements () {
    this.$posterImage = $('.blockMediaText-posterImage', this)
    this.$video = $('.blockMediaText-video', this)
    this.$iframe = $('iframe', this)
  }

  connectedCallback () {
    this.$posterImage.on('click', (e) => {
      this.startVideo()
    })
  }

  startVideo = () => {
    this.$iframe.attr('src', this.$iframe.data('src'))
    this.$video.addClass('blockMediaText-video-isVisible')
    this.$posterImage.addClass('blockMediaText-posterImage-isHidden')
  }
}

window.customElements.define('flynt-block-media-text', BlockMediaText, {extends: 'div'})
