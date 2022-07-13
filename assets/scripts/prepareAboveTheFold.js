/**
 * Prepare content that lazy loaded and above/inside the fold.
 */
export function prepareAboveTheFoldLazyLoadedElements () {
  // Add preload class to lazy loaded elements when they are above the fold.
  const aboveTheFoldElements = document.querySelectorAll('.lazyload')
  aboveTheFoldElements.forEach(function (element) {
    if (isPartInViewport(element)) {
      element.classList.add('lazypreload')
    }
  })

  // Remove loading tag if it exits.
  if (aboveTheFoldElements.length > 0) {
    window.addEventListener('lazybeforeunveil', function (e) {
      const element = e.target
      if (isPartInViewport(element)) {
        if ('loading' in element && element.getAttribute('loading') === 'lazy') {
          element.removeAttribute('loading')
        }
      }
    })
  }
}

function isPartInViewport (el) {
  const rect = el.getBoundingClientRect()
  const elementHeight = el.offsetHeight
  const elementWidth = el.offsetWidth

  return (
    rect.top >= -elementHeight &&
    rect.left >= -elementWidth &&
    rect.right <= (window.innerWidth || document.documentElement.clientWidth) + elementWidth &&
    rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) + elementHeight
  )
}
