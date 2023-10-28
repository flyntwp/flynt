const componentListToggle = document.querySelector('.component-list-toggle')
const componentListWrapper = document.querySelector('.component-list-wrapper')
if (componentListToggle && componentListWrapper) {
  componentListToggle.addEventListener('click', () => {
    const isOpen = componentListToggle.getAttribute('aria-expanded') === 'true'
    if (isOpen) {
      componentListToggle.setAttribute('aria-expanded', 'false')
      componentListWrapper.setAttribute('aria-hidden', 'true')
      window.removeEventListener('click', closeOnClickOutside)
    } else {
      componentListToggle.setAttribute('aria-expanded', 'true')
      componentListWrapper.setAttribute('aria-hidden', 'false')
      window.addEventListener('click', closeOnClickOutside)
    }
  })
}

function closeOnClickOutside (e) {
  const isClickInside = componentListWrapper.contains(e.target) || componentListToggle.contains(e.target)
  if (!isClickInside) {
    componentListToggle.setAttribute('aria-expanded', 'false')
    componentListWrapper.setAttribute('aria-hidden', 'true')
  }
}

const componentSearch = document.querySelector('.flyntComponentSearch')

if (componentSearch) {
  componentSearch.addEventListener('keyup', filterComponents)
}

function filterComponents (e) {
  const filter = e.target.value.toLowerCase()
  const componentList = document.querySelector('.component-list')
  const componentListItems = componentList.querySelectorAll('.component-list-item')
  componentListItems.forEach((item) => {
    const componentName = item.textContent.toLowerCase()
    if (componentName.indexOf(filter) > -1) {
      item.style.display = ''
    } else {
      item.style.display = 'none'
    }
  })
}
