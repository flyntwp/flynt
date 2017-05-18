import $ from 'jquery'
import 'file-loader?name=vendor/slick.js!slick-carousel/slick/slick.min'
import 'file-loader?name=vendor/slick.css!csso-loader!slick-carousel/slick/slick.css'

function importSlickFonts (fontName) { // eslint-disable-line no-unused-vars
  require(`file-loader?name=vendor/slick/[name].[ext]!slick-carousel/slick/fonts/${fontName}`)
}

import slickConfiguration from './sliderConfiguration.js'

class SliderMedia extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.sliderInitialised = false
    self.isMobile = false
    self.resolveElements()
    return self
  }

  resolveElements () {
    this.$sliderMedia = $('.sliderMedia', this)
    this.$slideTitle = $('.slideTitle', this)
    this.$mediaSlides = $('.sliderMedia-slides', this)
    this.$slides = $('.sliderMedia-slide', this)
    this.$posterImage = $('.oembedVideo-posterImageWrapper', this)
    this.$oembedVideo = $('.oembedVideo-video iframe', this)
  }

  connectedCallback () {
    this.setupSlider()
    this.$oembedVideo.on('load', this.onIframeLoad)
    this.$.on('click', this.$posterImage.selector, this.setIframeSrc)
  }

  setupSlider = () => {
    if (this.$slides.length > 1) {
      this.$.on('init', this.$mediaSlides.selector, this.slickInit)
      this.$mediaSlides.slick(slickConfiguration)
      this.$.on('beforeChange', this.$mediaSlides.selector, this.unsetIframeSrc)
    }
  }

  slickInit = () => {
    this.$sliderMedia.removeClass('sliderMedia-isHidden')
  }

  unsetIframeSrc = (e, slick, currentSlide, nextSlide) => {
    const $currentSlide = $(slick.$slides[currentSlide])
    $currentSlide.find('iframe').attr('src', '')
  }

  setIframeSrc = (e) => {
    const $oembedVideo = $(e.target).closest('.oembedVideo')
    const $iframe = $oembedVideo.find('iframe')
    const iframeSrc = $iframe.data('src')
    $iframe.attr('src', iframeSrc)
  }

  onIframeLoad = (e) => {
    const $iframe = $(e.target)
    const $oembedVideo = $iframe.closest('.oembedVideo')
    const $video = $oembedVideo.find('.oembedVideo-video')
    const $posterImage = $oembedVideo.find('.oembedVideo-posterImageWrapper')

    if ($iframe.attr('src')) {
      // show video
      $video.addClass('oembedVideo-video-isVisible')
      $posterImage.addClass('oembedVideo-posterImageWrapper-isHidden')
      if (this.$slideTitle.hasClass('slideTitle--overlayTitleTop') || this.$slideTitle.hasClass('slideTitle--overlayTitleBottom')) {
        this.$slideTitle.addClass('slideTitle-isHidden')
      }
    } else {
      // hide video
      $video.removeClass('oembedVideo-video-isVisible')
      $posterImage.removeClass('oembedVideo-posterImageWrapper-isHidden')
      this.$slideTitle.removeClass('slideTitle-isHidden')
    }
  }
}

window.customElements.define('flynt-slider-media', SliderMedia, {extends: 'div'})
