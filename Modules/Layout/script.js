class MainLayoutElement extends HTMLHtmlElement {
  // the self argument might be provided or not
  // in both cases, the mandatory `super()` call
  // will return the right context/instance to use
  // and eventually return
  constructor(self) {
    self = super(self);
    // self.addEventListener('click', console.log)
    // important in case you create instances procedurally:
    // var me = new MyElement()
    console.log('construct')
    return self
  }

  connectedCallback () {
    this.addEventListener('click', console.log)
    console.log('connected', this)
  }

  fire () {
    console.log('fire')
  }
}
console.log('FOO')
customElements.define('main-layout', MainLayoutElement, {extends: 'html'})
