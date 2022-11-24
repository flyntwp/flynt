/* globals location */

class BlockAnchor extends window.HTMLDivElement {
  constructor (...args) {
    const self = super(...args)
    self.init()
    return self
  }

  init () {
    this.resolveElements()
    this.bindFunctions()
    this.bindEvents()
  }

  resolveElements () {
    this.window = window
    this.document = document
    this.body = document.querySelector('body')
  }

  bindFunctions () {
    this.checkScrollToHash = this.checkScrollToHash.bind(this)
  }

  bindEvents () {
    // Delegated click event.
    this.body.addEventListener('click', (e) => {
      const { target } = e
      const href = target.getAttribute('href')

      /* detect local link */
      if (href && (location.hostname === target.hostname || !target.hostname)) {
        /* detect hash in link */
        if (href.indexOf('#') !== -1) {
          const hash = href.substr(href.indexOf('#'))
          e.preventDefault()
          this.smoothScrollTo(hash)
        }
      }
    })
  }

  connectedCallback () {
    if (this.window.location.hash && !(this.body.classList.contains('scrolledToHash'))) {
      this.body.classList.add('scrolledToHash')
      this.document.addEventListener('DOMContentLoaded', this.checkScrollToHash, { passive: true })
    }
  }

  checkScrollToHash () {
    const hash = this.window.location.hash
    if (hash) {
      setTimeout(() => {
        this.smoothScrollTo(hash)
      }, 750)
    }
  }

  smoothScrollTo (hash) {
    const target = this.document.querySelector(hash)
    if (target) {
      target.scrollIntoView({ behavior: 'smooth' })
    }
  }
}

window.customElements.define('flynt-block-anchor', BlockAnchor, { extends: 'div' })
