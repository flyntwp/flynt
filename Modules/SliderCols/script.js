import 'file-loader?name=vendor/normalize.css!normalize.css/normalize.css'

class SliderCols extends window.HTMLDivElement {
  connectedCallback () {
    console.log('SliderCols connected')
  }

  disconnectedCallback () {
    console.log('SliderCols disconnected')
  }
}

window.customElements.define('wps-SliderCols', SliderCols, {extends: 'div'})
