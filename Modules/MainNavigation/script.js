class MainNavigation extends window.HTMLDivElement {
  connectedCallback () {
    console.log('MainNavigation connected')
  }

  disconnectedCallback () {
    console.log('MainNavigation disconnected')
  }
}

window.customElements.define('main-navigation', MainNavigation, {extends: 'div'})
