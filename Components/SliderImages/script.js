import Swiper, { Navigation, A11y, Autoplay, Lazy } from 'swiper'
import 'swiper/css/bundle'
import { buildRefs, getJSON } from '@/assets/scripts/helpers.js'

export default function (sliderImages) {
  const refs = buildRefs(sliderImages)
  const data = getJSON(sliderImages)
  const swiper = initSlider(refs, data)
  return () => swiper.destroy()
}

function initSlider (refs, data) {
  const { options } = data
  const config = {
    modules: [Navigation, A11y, Lazy, Autoplay],
    a11y: options.a11y,
    roundLengths: true,
    navigation: {
      nextEl: refs.next,
      prevEl: refs.prev
    },
    lazy: {
      loadPrevNext: true
    }
  }
  if (options.autoplay && options.autoplaySpeed) {
    config.autoplay = {
      delay: options.autoplaySpeed
    }
  }

  return new Swiper(refs.slider, config)
}
