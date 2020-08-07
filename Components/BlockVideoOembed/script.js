import $ from 'jquery'

class BlockVideoOembed extends window.HTMLDivElement {
  constructor (...args) {
    const self = super(...args)
    self.init()
    return self
  }

  init () {
    this.$ = $(this)
    this.resolveElements()
    this.bindFunctions()
    this.bindEvents()
  }

  resolveElements () {
    this.$posterImage = $('.figure-image', this)
    this.$videoPlayer = $('.video-player', this)
    this.$iframe = $('iframe', this)
  }

  bindFunctions () {
    this.loadVideo = this.loadVideo.bind(this)
    this.videoIsLoaded = this.videoIsLoaded.bind(this)
  }

  bindEvents () {
    this.$.one('click', '.video-playButton', this.loadVideo)
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
