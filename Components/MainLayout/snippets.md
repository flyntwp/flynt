# MainLayout Snippets

## Boilerplates

`script.js`

```javascript
class MainLayout extends window.HTMLHtmlElement {

  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.resolveElements()
    return self
  }

  resolveElements () {
  }

  connectedCallback () {
  }

}

window.customElements.define('flynt-main-layout', MainLayout, {extends: 'html'})
```
