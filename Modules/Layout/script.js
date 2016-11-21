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
    self.$ = $(self)
    self._elements = {
      a: 'a',
      someName: 'div'
    }
    self._attachListeners()
    self._resolveElements()
    return self
  }

  $$ (selector) {
    return $(selector, this)
  }

  connectedCallback () {
    this.boo = 'boo'
    console.log('connected', this)
  }

  _attachListeners () {
    this.addEventListener('click', console.log)
    this.addEventListener('click', (e) => {
      if (Array.prototype.indexOf.call(this.querySelectorAll('a'), e.target))
        this.logAnchor(e)
    })
    this.$.on('click', console.log)
    this.$.on('click', 'a', this.logAnchor.bind(this))
  }

  _resolveElements () {
    this.$elements = {
      a: this.$$('a')
    }
    this.elements = {
      a: this.querySelectorAll('a')
    }
  }

  getChildElement (name, noCache = false) {
    this._elementsCache = this._elementsCache || {}
    if (this._elements && this._elements[name]) {
      selector = this._elements[name]
      cachedEl = this._elementsCache[name]
      if (noCache || !cachedEl) {
        el = this.$$(selector)
        if (!noCache) {
          this._elementsCache[name] = el
        }
      } else {
        el = cachedEl
      }
      return el
    }
  }

  logAnchor (e) {
    e.preventDefault()
    console.log(this.boo, e.currentTarget)
    console.log(e);
  }

  fire () {
    console.log('fire')
  }
}
console.log('main-layouts')
customElements.define('main-layout', MainLayoutElement, {extends: 'html'})
