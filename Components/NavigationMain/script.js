import Headroom from 'headroom.js'

export default function (el) {
  let headroom
  const navigationHeight = parseInt(window.getComputedStyle(el).getPropertyValue('--navigation-height')) || 0

  const isDesktopMediaQuery = window.matchMedia('(min-width: 1024px)')
  isDesktopMediaQuery.addEventListener('change', onBreakpointChange)

  onBreakpointChange()
  setScrollPaddingTop()

  function initHeadroom () {
    if (headroom) {
      return
    }

    headroom = new Headroom(el, {
      offset: navigationHeight,
      tolerance: {
        up: 5,
        down: 0
      }
    })
  }

  function onBreakpointChange () {
    if (isDesktopMediaQuery.matches) {
      setScrollPaddingTop()
      initHeadroom()
      if (!headroom.initialised) headroom.init()
    } else {
      if (headroom?.initialised) headroom.destroy()
    }
  }

  function setScrollPaddingTop () {
    if (isDesktopMediaQuery.matches) {
      const scrollPaddingTop = document.getElementById('wpadminbar')
        ? navigationHeight + document.getElementById('wpadminbar').offsetHeight
        : navigationHeight
      document.documentElement.style.scrollPaddingTop = `${scrollPaddingTop}px`
    }
  }
}
