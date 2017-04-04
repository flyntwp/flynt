// TODO: hide poster after video is succesfully loaded

class BlockVideoOembed extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.resolveElements()
    return self
  }

  resolveElements () {
    this.$posterImage = $('.blockVideoOembed-posterImage', this)
    this.$video = $('.blockVideoOembed-video', this)
    this.$iframe = $('iframe', this)
  }

  connectedCallback () {
    this.$posterImage.on('click', (e) => {
      this.startVideo()
    })
  }

  startVideo = () => {
    this.$iframe.attr('src', this.$iframe.data('src'))
    this.$video.addClass('blockVideoOembed-video-isVisible')
    this.$posterImage.addClass('blockVideoOembed-posterImage-isHidden')
  }
}

window.customElements.define('flynt-block-video-oembed', BlockVideoOembed, {extends: 'div'})
