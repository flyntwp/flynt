import 'file-loader?name=vendor/jquery.fitvids.js!fitvids/jquery.fitvids.js'

class Oembed extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.resolveElements()
    return self
  }

  resolveElements () {
    this.$posterImage = $('.oembed-posterImage', this)
    this.$video = $('.oembed-video', this)
    this.$iframe = $('iframe', this)
  }

  connectedCallback () {
    this.$.fitVids()
    this.$posterImage.on('click', (e) => {
      this.startVideo()
    })
  }

  startVideo = () => {
    const $autoplay = this.$iframe.attr('src') + '&autoplay=1'
    this.$posterImage.addClass('isHidden')
    this.$video.addClass('isActive')
    this.$iframe.attr('src', $autoplay)
  }
}

window.customElements.define('wps-oembed', Oembed, {extends: 'div'})
