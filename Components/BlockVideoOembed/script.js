import $ from 'jquery'

class BlockVideoOembed extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.resolveElements()
    return self
  }

  resolveElements () {
    this.$posterImage = $('.video-posterImage', this)
    this.$videoContent = $('.video-content', this)
    this.$iframe = $('iframe', this)
    this.$play = $('.play', this)
    this.$loader = $('.loader', this)
  }

  connectedCallback () {
    this.$.on('click', this.$posterImage.selector, this.setIframeSrc.bind(this))
    this.$iframe.on('load', this.onIframeLoad.bind(this))
    this.videoIsStopped()
  }

  setIframeSrc = () => {
    this.$iframe.attr('src', this.$iframe.data('src'))
    this.videoIsLoading()
  }

  onIframeLoad = () => {
    if (this.$iframe.attr('src') !== undefined && this.$iframe.attr('src') !== '') {
      this.$videoContent.addClass('video-content-isVisible')
      this.$posterImage.addClass('video-posterImage-isHidden')
      this.videoIsPlaying()
    }
  }

  videoIsStopped () {
    this.$play.addClass('play--isVisible')
    this.$loader.removeClass('loader--isVisible')
  }

  videoIsLoading () {
    this.$play.removeClass('play--isVisible')
    this.$loader.addClass('loader--isVisible')
  }

  videoIsPlaying () {
    this.$play.removeClass('play--isVisible')
    this.$loader.removeClass('loader--isVisible')
  }
}

window.customElements.define('flynt-block-video-oembed', BlockVideoOembed, {extends: 'div'})
