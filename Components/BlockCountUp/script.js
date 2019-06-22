
/* globals IntersectionObserver */
import $ from 'jquery'
import 'intersection-observer'
import { CountUp } from 'countup.js'

class BlockCountUp extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.resolveElements()
    return self
  }

  resolveElements () {
    this.$items = $('.item', this)
  }

  connectedCallback () {
    this.observer = new IntersectionObserver(this.triggerAnimation.bind(this), {
      threshold: 1.0
    })
    $.each(this.$items, (i, item) => {
      this.observer.observe(item)
    })
  }

  triggerAnimation (entries) {
    entries.forEach(entry => {
      if (entry.intersectionRatio > 0) {
        this.observer.unobserve(entry.target)
        const $numbers = $(entry.target).find('.number')

        $.each($numbers, (i, number) => {
          const $number = $(number)
          const displayNumber = $number.data('number')
          const displaySuffix = $number.data('suffix')
          const displayPrefix = $number.data('prefix')
          const duration = 2
          let count = new CountUp(number, displayNumber, {
            duration: duration,
            decimalPlaces: 0,
            prefix: displayPrefix,
            suffix: displaySuffix
          })
          count.start()
        })
      }
    })
  }
}

window.customElements.define('flynt-block-count-up', BlockCountUp, { extends: 'div' })
