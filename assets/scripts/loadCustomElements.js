let requiresCePolyfill
try {
  const is = 'built-in-test'
  window.customElements.define(
    is,
    class extends window.HTMLParagraphElement {},
    { extends: 'p' }
  )
  const el = document.createElement('p', { is })
  if (!el.outerHTML.includes(is)) {
    requiresCePolyfill = true
  }
} catch (s) {
  requiresCePolyfill = true
}
if (requiresCePolyfill) {
  import('@webreflection/custom-elements-builtin')
}
