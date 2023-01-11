import { disableBodyScroll, enableBodyScroll } from 'body-scroll-lock'
import Headroom from 'headroom.js'
import delegate from 'delegate-event-listener'
import { buildRefs } from '@/assets/scripts/helpers.js'

export default function (el) {
  let headroom, isMenuOpen
  const refs = buildRefs(el)
  const navigationHeight = parseInt(window.getComputedStyle(el).getPropertyValue('--navigation-height')) || 0

  const isDesktopMediaQuery = window.matchMedia('(min-width: 1024px)')
  isDesktopMediaQuery.addEventListener('change', onBreakpointChange)

  el.addEventListener('click', delegate('[data-ref="menuButton"]', onMenuButtonClick))

  onBreakpointChange()

  function onMenuButtonClick (e) {
    isMenuOpen = !isMenuOpen
    refs.menuButton.setAttribute('aria-expanded', isMenuOpen)

    if (isMenuOpen) {
      el.setAttribute('data-status', 'menuIsOpen')
      disableBodyScroll(refs.menu)
    } else {
      el.removeAttribute('data-status')
      enableBodyScroll(refs.menu)
    }
  }

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
      if (headroom?.initialised) headroom.destroy()
    } else {
      setScrollPaddingTop()
      initHeadroom()
      if (!headroom.initialised) headroom.init()
    }
  }

  function setScrollPaddingTop () {
    const scrollPaddingTop = document.getElementById('wpadminbar')
      ? navigationHeight + document.getElementById('wpadminbar').offsetHeight
      : navigationHeight
    document.documentElement.style.scrollPaddingTop = `${scrollPaddingTop}px`
  }
}
