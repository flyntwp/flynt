import 'file-loader?name=vendor/console.js!uglify-loader!console-polyfill'
import 'file-loader?name=vendor/babel-polyfill.js!babel-polyfill/dist/polyfill.min'
import 'file-loader?name=vendor/document-register-element.js!document-register-element/build/document-register-element'
import 'file-loader?name=vendor/picturefill.js!picturefill/dist/picturefill.min'
import 'file-loader?name=vendor/normalize.css!csso-loader!normalize.css/normalize.css'

class MainLayoutElement extends window.HTMLHtmlElement {
  // the self argument might be provided or not
  // in both cases, the mandatory `super()` call
  // will return the right context/instance to use
  // and eventually return
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.resolveElements()
    return self
  }

  $$ (selector) {
    return $(selector, this)
  }

  resolveElements () {
  }

  connectedCallback () {
  }

}
window.customElements.define('flynt-main-layout', MainLayoutElement, {extends: 'html'})
