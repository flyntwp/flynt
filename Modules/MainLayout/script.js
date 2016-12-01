import 'file-loader?name=vendor/console.js!console-polyfill'
import 'file-loader?name=vendor/babel-polyfill.js!babel-polyfill/dist/polyfill'
import 'file-loader?name=vendor/document-register-element.js!document-register-element/build/document-register-element'
import 'file-loader?name=vendor/normalize.css!normalize.css/normalize.css'

class MainLayoutElement extends window.HTMLHtmlElement {
  // the self argument might be provided or not
  // in both cases, the mandatory `super()` call
  // will return the right context/instance to use
  // and eventually return
  constructor (self) {
    self = super(self)
    // self.addEventListener('click', console.log)
    // important in case you create instances procedurally:
    // var me = new MyElement()
    self.$ = $(self)
    return self
  }

  $$ (selector) {
    return $(selector, this)
  }

  connectedCallback () {
  }

}
window.customElements.define('wps-main-layout', MainLayoutElement, {extends: 'html'})
