import { debounce } from 'lodash-es'
import { buildRefs } from '@/assets/scripts/helpers'

const parallaxConfigs = new Map()

export default function (el) {
  const multiRefs = buildRefs(el, true)
  const delegatedToggleHoverScroll = e =>
    e.target.matches('.componentLink') ? toggleHoverScroll(e) : null

  connect()
  isDesktopQueryList.addEventListener('change', () => {
    disconnect()
    connect()
  })

  function connect () {
    if (isDesktop()) {
      el.addEventListener('mouseenter', delegatedToggleHoverScroll, true)
      el.addEventListener('mouseleave', delegatedToggleHoverScroll, true)
    } else {
      window.addEventListener('resize', debounce(setParallaxConfig, 250))
      document.addEventListener('lazyloaded', setParallaxConfig)
      window.addEventListener('scroll', startParallaxScroll, { passive: true })
    }
  }
  function disconnect () {
    el.removeEventListener('mouseenter', delegatedToggleHoverScroll, true)
    el.removeEventListener('mouseleave', delegatedToggleHoverScroll, true)
    window.removeEventListener('resize', setParallaxConfig)
    document.removeEventListener('lazyloaded', setParallaxConfig)
    window.removeEventListener('scroll', startParallaxScroll, { passive: true })
  }

  function setParallaxConfig (e) {
    const { scrollY, innerHeight } = window
    const { clientTop } = document.documentElement

    parallaxConfigs.clear()
    multiRefs.images.forEach(image => {
      const imageWrapper = image.parentElement

      const imageOverflow = image.offsetHeight - imageWrapper.offsetHeight
      const topOffset =
        imageWrapper.getBoundingClientRect().top + scrollY - clientTop
      const startOffset = topOffset - innerHeight * 0.4
      const endOffset = topOffset - 100

      if (imageOverflow > 0) {
        parallaxConfigs.set(image, {
          imageOverflow,
          startOffset,
          endOffset
        })
      }
    })

    startParallaxScroll()
  }

  function startParallaxScroll (e) {
    const { scrollY } = window

    parallaxConfigs.forEach((parallaxConfig, image) => {
      let scrollPercentage =
        (scrollY - parallaxConfig.startOffset) /
        (parallaxConfig.endOffset - parallaxConfig.startOffset)
      scrollPercentage = Math.min(Math.max(scrollPercentage, 0), 1)
      const move = scrollPercentage * parallaxConfig.imageOverflow * -1
      if (
        !e ||
        (scrollY >= parallaxConfig.startOffset &&
          scrollY < parallaxConfig.endOffset)
      ) {
        image.style.transform = 'translateY(' + move + 'px)'
      }
    })
  }
}

const isDesktopQueryList = window.matchMedia('(min-width: 1280px)')
const isDesktop = () => isDesktopQueryList.matches

/**
 *
 * @param {Event} e
 */
function toggleHoverScroll (e) {
  const target = e.delegateTarget || e.target
  const imageWrapper = target.querySelector('.imageWrapper')
  const imageWrapperHeight = imageWrapper.offsetHeight
  const image = imageWrapper.querySelector('img')
  const imageHeight = image.offsetHeight

  if (imageHeight > imageWrapperHeight) {
    if (e.type === 'mouseenter') {
      image.style.transition =
        'transform ' +
        Math.max((imageHeight - imageWrapperHeight) / imageWrapperHeight, 0.3) +
        's cubic-bezier(0.215, 0.61, 0.355, 1)'
      image.style.transform =
        'translateY(-' + (imageHeight - imageWrapperHeight) + 'px)'
    } else {
      image.style.transition =
        'transform ' +
        Math.max((imageHeight - imageWrapperHeight) / imageWrapperHeight, 0.3) +
        's cubic-bezier(0.23, 1, 0.32, 1)'
      image.style.transform = 'translateY(0)'
    }
  }
}
