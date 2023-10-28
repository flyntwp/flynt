/* globals acf jQuery */
import './scripts/component-list'
import './scripts/screen-toggles'

const componentList = document.getElementById('component-list')
if (componentList) {
  const anchors = componentList.querySelectorAll('.component-list-item')
  for (const anchor of anchors) {
    anchor.addEventListener('click', (e) => {
      e.preventDefault()
      const componentName = anchor.dataset.componentName
      const url = new URL(window.location)
      url.searchParams.set('component', componentName)
      window.location = url
    })
  }
}

const flyntRenderer = document.getElementById('flynt-renderer')
if (flyntRenderer) {
  if (
    document.readyState === 'complete' ||
    document.readyState === 'interactive'
  ) {
    init()
  } else {
    document.addEventListener('DOMContentLoaded', () => {
      init()
    })
  }
}

function init () {
  const connections = []
  const wrapper = document.querySelector('.flyntStudio-iframes')
  import('penpal').then(({ connectToChild }) => {
    ;['mobile', 'tablet', 'desktop'].forEach((device) => {
      const iframe = document.createElement('iframe')
      const foowrapper = document.createElement('div')
      iframe.src = '/renderer'
      foowrapper.classList.add(device)
      foowrapper.appendChild(iframe)
      wrapper.appendChild(foowrapper)
      connections.push(connectToChild({
        iframe
      }))
    })
  })
  acf.addAction('ready', (e) => { submit() })
  jQuery(flyntRenderer).on('change', (e) => {
    // console.log('flynt-renderer changed')
    // localStorage.setItem('input_' + e.target.name, e.target.value)
    // const url = new URL(window.location)
    // const formData = new FormData(flyntRenderer)
    // formData.delete('_acf_form')
    // url.searchParams.set('customData', JSON.stringify(Object.fromEntries(formData)))
    // history.pushState(null, null, url)
    submit()
  })
  flyntRenderer.addEventListener('submit', async (e) => {
    console.log('flynt-renderer submitted')
    e.preventDefault()
    submit()
  })

  document.getElementById('iframe-scale').addEventListener('change', e => {
    wrapper.style.setProperty('--iframe-scale', e.target.value)
  })

  async function submit () {
    const { adminAjaxUrl } = window.FlyntData
    const response = await fetch(adminAjaxUrl, {
      method: 'POST',
      credentials: 'same-origin',
      body: new FormData(flyntRenderer)
    })
    const html = await response.text()
    connections.forEach(connection => {
      connection.promise.then(child => {
        child.render(html)
      })
    })
  }
}
