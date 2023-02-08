import { buildRefs } from '@/assets/scripts/helpers'

export default function (el) {
  const refs = buildRefs(el, false, {
    iframe: 'iframe'
  })

  refs.playButton.addEventListener('click', loadVideo, { once: true })

  function loadVideo () {
    refs.iframe.addEventListener('load', videoIsLoaded, { once: true })
    refs.iframe.setAttribute('src', refs.iframe.getAttribute('data-src'))
    refs.videoPlayer.dataset.state = 'isLoading'
  }

  function videoIsLoaded () {
    refs.videoPlayer.dataset.state = 'isLoaded'
    refs.posterImage.dataset.state = 'isHidden'
  }
}
