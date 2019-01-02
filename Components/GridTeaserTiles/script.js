import $ from 'jquery'

class GridTeaserTiles extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.resolveElements()
    return self
  }

  resolveElements () {
  }

  connectedCallback () {
  }
}

window.customElements.define('flynt-grid-teaser-tiles', GridTeaserTiles, { extends: 'div' })
