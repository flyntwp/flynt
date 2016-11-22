const Mixin = window.mixwith.Mixin

const jQueryElementHelper = Mixin((Superclass) => class extends Superclass {
  constructor (_) {
    (_ = super(_)).init()
    _.$ = $(_)
    return _
  }
  init () { /* override as you like */ }

  $$ (selector) {
    return $(selector, this)
  }
})

const ElementHelper = Mixin((Superclass) => class extends Superclass {
  constructor (_) {
    (_ = super(_)).init()
    _._attachListeners(_.listeners)
    _._resolveElements(_.elements)
    console.log('elHelper', _)
    return _
  }
  init () { /* override as you like */ }

  _attachListeners (listeners) {
    Object.keys(listeners).forEach((listener) => {
      const callback = listeners[listener]
      const listenerSplit = listener.split(' ')
      const event = listenerSplit.shift()
      if (listenerSplit.length) {
        const selector = listenerSplit.join(' ')
        console.log('attachEvents', event, selector)
        this.$.on(event, selector, callback.bind(this))
      } else {
        console.log('attachEvents', event)
        this.$.on(event, callback.bind(this))
      }
    })
  }

  _resolveElements (elements) {
    Object.keys(elements).forEach((element) => {
      this[`$${element}`] = this.$$(elements[element])
      console.log(element, elements[element])
    })
  }
})

const mix = window.mixwith.mix

class MainTemplate extends mix(window.HTMLDivElement).with(jQueryElementHelper, ElementHelper) {
  init () {
    this.elements = {
      modules: '.modules',
      h2: 'h2'
    }
    this.listeners = {
      'click': this.onClick,
      'click h2': this.onH2Click
    }
  }

  // get elements () {
  //   return {
  //     modules: '.modules',
  //     h2: 'h2'
  //   }
  // }
  //
  // get listeners () {
  //   return {
  //     'click': this.onClick,
  //     'click h2': this.onH2Click
  //   }
  // }

  onClick () {
    console.log('simple click')
  }

  onH2Click () {
    console.log('h2 click')
  }
}

window.customElements.define('main-template', MainTemplate, {extends: 'div'})
