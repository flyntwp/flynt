
class BlockVideoOembed extends window.HTMLDivElement {
  constructor (...args) {
    const self = super(...args)
    self.init()
    return self
  }

  init () {
    this.resolveElements()
    this.bindFunctions()
    this.bindEvents()
  }

  resolveElements () {
    this.playButton = this.querySelector('.video-playButton')
    this.posterImage = this.querySelector('.figure')
    this.videoPlayer = this.querySelector('.video-player')
    this.iframe = this.querySelector('iframe')
  }

  bindFunctions () {
    this.loadVideo = this.loadVideo.bind(this)
    this.videoIsLoaded = this.videoIsLoaded.bind(this)
  }

  bindEvents () {
    this.playButton.addEventListener('click', this.loadVideo, { once: true })
  }

  loadVideo () {
    this.iframe.addEventListener('load', this.videoIsLoaded.bind(this), { once: true })
    this.iframe.setAttribute('src', this.iframe.getAttribute('data-src'))
    this.videoPlayer.dataset.state = 'isLoading'
  }

  videoIsLoaded () {
    this.videoPlayer.dataset.state = 'isLoaded'
    this.posterImage.dataset.state = 'isHidden'
  }
}

window.customElements.define('flynt-block-video-oembed', BlockVideoOembed, { extends: 'div' })
