import $ from 'jquery'

class BlockVideoOembed extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.resolveElements()
    return self
  }

  resolveElements () {
    this.loadVideo = this.loadVideo.bind(this)
    this.$posterImage = $('.figure-image', this)
    this.$videoPlayer = $('.video-player', this)
    this.$iframe = $('iframe', this)
    this.$playBtn = $('.video-playBtn', this)
  }

  connectedCallback () {
    this.$.one('click', this.$playBtn.selector, this.loadVideo.bind(this))
  }

  loadVideo () {
    this.$iframe.one('load', this.videoIsLoaded.bind(this))
    this.$iframe.attr('src', this.$iframe.data('src'))
    this.$videoPlayer.addClass('video-player--isLoading')
  }

  videoIsLoaded () {
    this.$videoPlayer.removeClass('video-player--isLoading')
    this.$videoPlayer.addClass('video-player--isLoaded')
    this.$posterImage.addClass('figure-image--isHidden')
  }
}

window.customElements.define('flynt-block-video-oembed', BlockVideoOembed, { extends: 'div' })
