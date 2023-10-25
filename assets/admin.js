if (import.meta.env.DEV) {
  import('@vite/client')
}

import.meta.glob('../Components/**/admin.js', { eager: true })


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
    });
  }
}

function init() {
  const connections = []
  const wrapper = document.getElementById('postmate')
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
  // const handshakes = []
  // import('postmate').then(({ default: Postmate }) => {
  //   handshakes.push(new Postmate({
  //     container: document.getElementById('postmate'),
  //     name: 'postmate-mobile',
  //     url: '/renderer',
  //     classListArray: ['mobile']
  //   }))
  //   handshakes.push(new Postmate({
  //     container: document.getElementById('postmate'),
  //     name: 'postmate-tablet',
  //     url: '/renderer',
  //     classListArray: ['tablet']
  //   }))
  //   handshakes.push(new Postmate({
  //     container: document.getElementById('postmate'),
  //     name: 'postmate-desktop',
  //     url: '/renderer',
  //     classListArray: ['desktop']
  //   }))
  // })
  // jQuery(flyntRenderer).on('change', function () {
  //   console.log('jq change')
  // })
  // jQuery(flyntRenderer).on('changed', function () {
  //   console.log('jq changed')
  // })
  acf.addAction('ready', (e) => {submit()})
  // acf.addAction('prepare_field', (e) => {console.log('prepare_field', e)})
  // acf.addAction('ready_field', (e) => {console.log('ready_field', e)})
  // flyntRenderer.querySelectorAll('input').forEach(input => {
  //   const value = localStorage.getItem('input_' + input.name)
  //   if (value) {
  //     // const matches = input.name.match(/\[(field_\w+)\]/g)
  //     // console.log(input.name, matches)
  //     // input.value = value
  //     acf.val(jQuery(input), value, true)
  //   }
  // })
  jQuery(flyntRenderer).on('change', (e) => {
    console.log('flynt-renderer changed')
    localStorage.setItem('input_' + e.target.name, e.target.value)
    const url = new URL(window.location)
    const formData = new FormData(flyntRenderer)
    formData.delete('_acf_form')
    url.searchParams.set('customData', JSON.stringify(Object.fromEntries(formData)))
    history.pushState(null, null, url)
    submit()
  })
  flyntRenderer.addEventListener('submit', async (e) => {
    console.log('flynt-renderer submitted')
    e.preventDefault()
    // wp.apiFetch({
    //   path: 'flynt/v1/render',
    //   method: 'POST',
    //   data: Object.fromEntries(new FormData(flyntRenderer))
    // })
    submit()
  })

  document.getElementById('iframe-scale').addEventListener('change', e => {
    wrapper.style.setProperty('--iframe-scale', e.target.value)
  })

  async function submit() {
    const response = await fetch('/wp/wp-admin/admin-ajax.php', {
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
