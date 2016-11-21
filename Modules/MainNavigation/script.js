class MainNavigation extends HTMLDivElement {
  connectedCallback () {
    console.log('MainNavigation connected')
  }

  disconnectedCallback () {
    console.log('MainNavigation disconnected')
  }
}

customElements.define('main-navigation', MainNavigation, {extends: 'div'})
