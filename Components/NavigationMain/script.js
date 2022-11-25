import Headroom from 'headroom.js'

export default function (el) {
  let headroom

  const isDesktopMediaQuery = window.matchMedia('(min-width: 1024px)')
  isDesktopMediaQuery.addEventListener('change', onBreakpointChange)

  onBreakpointChange()

  function initHeadroom () {
    if (headroom) {
      return
    }
    const navigationHeight = parseInt(window.getComputedStyle(el).getPropertyValue('--navigation-height')) || 0

    headroom = new Headroom(el, {
      offset: navigationHeight,
      tolerance: {
        up: 5,
        down: 0
      }
    })
  }

  function onBreakpointChange() {
    if (isDesktopMediaQuery.matches) {
      initHeadroom()
      if (!headroom.initialised) headroom.init()
    } else {
      if (headroom?.initialised) headroom.destroy()
    }
  }
}
