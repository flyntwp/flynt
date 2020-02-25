import $ from 'jquery'

class GridImageText extends window.HTMLDivElement {
  constructor (...args) {
    const self = super(...args)
    self.init()
    return self
  }

  init () {
    this.$ = $(this)
    this.resolveElements()
  }

  resolveElements () {
    this.$items = $('.content', this)
  }

  connectedCallback () {
    this.$items.each((i, el) => {
      const $el = $(el)
      const $link = $el.find('.content-link')
      if ($link.length) {
        let down = 0
        let up = 0
        $el.css('cursor', 'pointer')
        $el.on('mousedown', () => {
          down = +new Date()
        })
        $el.on('mouseup', () => {
          up = +new Date()
          if ((up - down) < 200) {
            $link.get(0).click()
          }
        })
      }
    })
  }
}

window.customElements.define('flynt-grid-image-text', GridImageText, { extends: 'div' })
