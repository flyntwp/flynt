class BlockCollapse extends window.HTMLDivElement {
  connectedCallback () {
    const previousElementTheme = this.parentElement.previousElementSibling.getAttribute('data-theme')
    if (previousElementTheme) {
      this.setAttribute('data-theme', previousElementTheme)
    }
  }
}

window.customElements.define('flynt-block-collapse', BlockCollapse, { extends: 'div' })
