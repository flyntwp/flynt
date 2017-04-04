# DocumentDefault Snippets

## Boilerplates

`script.js`

```javascript
class DocumentDefault extends window.HTMLHtmlElement {

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

window.customElements.define('flynt-document-default', DocumentDefault, {extends: 'html'})
```
