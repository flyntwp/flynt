/**
 * Dynamic import feather-icons and replace all elements
 * that have a data-feather attribute with SVG markup
 * only if markup exits inside the document.
 */
export function initFeatherIcons () {
  const dataFeather = document.querySelector('[data-feather]')
  if (dataFeather) {
    import('feather-icons').then(feather => feather.replace())
  }
}

/**
 * Add feather icon markup to the
 * class .iconList--checkCircle
 */
export function addFeatherIconToListCheckCircle () {
  const iconListCheckCircleElements = document.querySelectorAll('.iconList--checkCircle')
  iconListCheckCircleElements.forEach(function (element) {
    const children = [...element.children]
    children.forEach(function (child) {
      child.insertAdjacentHTML('afterbegin', '<i data-feather=check-circle></i>')
    })
  })
}
