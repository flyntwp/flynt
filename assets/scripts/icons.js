export async function initIcons () {
  const iconsEl = document.querySelectorAll('iconify-icon')

  if (iconsEl) {
    const { loadIcons } = await import('iconify-icon')
    const iconsName = [...iconsEl].map(component => component.getAttribute('icon'))

    loadIcons(iconsName, (loaded, missing, pending, unsubscribe) => {
      if (loaded.length) {
        console.log(`Icon ${iconsName} have been loaded and is ready to be renderered.`)
        return
      }

      if (missing.length) {
        console.log(`Icon ${iconsName} does not exist.`)
        return
      }

      if (pending.length) {
        console.log(`Icon ${iconsName} pending.`)
      }
    })
  }
}

export async function addCustomIcons () {
  const { addCollection } = await import('iconify-icon')
  const url = window.FlyntData.iconsCustomDirectory += '/interlude.json'

  const loadData = async (url, key) => {
    let data = window.localStorage.getItem(key)

    if (data) {
      data = JSON.parse(data)
      if (Date.now() - data.lastUsed > 600000) { // 10mins
        window.localStorage.removeItem(key)
        data = null
      }
    }

    if (!data) {
      data = await fetch(url).then(response => response.json())
      data.lastUsed = Date.now()
      window.localStorage.setItem(key, JSON.stringify(data))
    }

    return data
  }

  await loadData(url, 'interlude-icons').then((data) => {
    addCollection(data)
  })
}

// export function addCustomAPIProviders () {
//  window.IconifyProviders = {
//    '': {
//      resources: [window.FlyntData.iconsProviderUrl]
//    }
//  }
// }
