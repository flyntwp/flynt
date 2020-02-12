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
    this.$gridCard = $('.grid-card', this)
  }

  connectedCallback () {
    this.$gridCard.each((i, el)=>{
      if ($(el).find('.button--link').length) {
        let down, up, link = $(el).find('.button--link')
        $(el).css('cursor', 'pointer')
        $(el).on('mousedown', () => down = +new Date())
        $(el).on('mouseup', () => {
              up = +new Date();
              if ((up - down) < 200) {
                link.get(0).click()
              }
        })
      }
    })
  }
}

window.customElements.define('flynt-grid-image-text', GridImageText, { extends: 'div' })
