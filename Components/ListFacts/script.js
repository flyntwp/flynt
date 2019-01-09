
/* globals IntersectionObserver, CountUp */
import $ from 'jquery'
import 'countup.js'
import 'intersection-observer'

class ListFacts extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.resolveElements()
    return self
  }

  resolveElements () {
    this.$rows = $('.fact', this)
  }

  connectedCallback () {
    let options = {
      threshold: 1.0
    }
    this.observer = new IntersectionObserver(this.triggerAnimation.bind(this), options)
    $.each(this.$rows, (i, row) => {
      this.observer.observe(row)
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
          const countNumber = $number.data('count-number') ? $number.data('count-number') : displayNumber
          const duration = Math.log(countNumber) / 3
          const count = new CountUp(number, 0, displayNumber, 0, duration, { separator: '.' })
          count.start()
        })
      }
    })
  }
}

window.customElements.define('flynt-list-facts', ListFacts, { extends: 'div' })
