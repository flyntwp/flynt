/* globals FlyntData, FlyntComponentScreenshots */

function init () {
  // Add delegated events.
  document.addEventListener('mouseenter', (e) => {
    const { target } = e

    if (typeof target === 'object' && target !== null && 'getAttribute' in target && target.matches('a[data-layout]')) {
      const layout = target.dataset.layout
      showComponentScreenshot(layout, target)
    }
  }, true)

  document.addEventListener('mouseleave', (e) => {
    const { target } = e

    if (typeof target === 'object' && target !== null && 'getAttribute' in target && target.matches('a[data-layout]')) {
      hideComponentScreenshot(target)
    }
  }, true)
}

function showComponentScreenshot (layout, wrapper) {
  const componentName = firstToUpperCase(layout)
  const image = `${FlyntData.templateDirectoryUri}/${FlyntComponentScreenshots.components[componentName]}/screenshot.png`
  const wrapperContainer = document.createElement('div')

  wrapperContainer.classList.add('flyntComponentScreenshot-imageWrapper')
  wrapper.append(wrapperContainer)

  const img = document.createElement('img')
  img.classList.add('flyntComponentScreenshot-previewImageLarge')
  img.src = image

  wrapperContainer.prepend(img)
}

function hideComponentScreenshot (wrapper) {
  const wrapperContainer = wrapper.querySelector('.flyntComponentScreenshot-imageWrapper')
  wrapperContainer.remove()
}

function firstToUpperCase (str) {
  return str.substr(0, 1).toUpperCase() + str.substr(1)
}

init()
