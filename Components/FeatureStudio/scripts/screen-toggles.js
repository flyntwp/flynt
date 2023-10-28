const screenToggles = document.querySelectorAll('.screen-toggle')

if (screenToggles.length > 0) {
  screenToggles.forEach((screenToggle) => {
    screenToggle.addEventListener('change', (e) => {
      const checked = e.target.checked
      const screen = e.target.value
      const iframe = document.querySelector(`.flyntStudio-iframes .${screen}`)
      if (checked) {
        console.log(iframe)
        iframe?.classList.remove('hidden')
      } else {
        iframe?.classList.add('hidden')
      }
    })
  })
}
