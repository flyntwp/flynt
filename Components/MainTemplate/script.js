/* globals HTMLDivElement, customElements */

class MainTemplate extends HTMLDivElement {
  constructor (el) {
    const self = super(el)
    this.resolveElements()
    this.addListeners()
    return self
  }

  resolveElements () {
    this.$ = $(this)
    this.$foo = $('.foo', this)
  }

  addListeners () {
    this.$.on('click', this.onClick)
    this.$.on('click h2', this.onH2Click)
  }

  onClick () {
    console.log('simple click')
  }

  onH2Click () {
    console.log('h2 click')
  }
}

customElements.define('wps-main-template', MainTemplate, {extends: 'div'})
