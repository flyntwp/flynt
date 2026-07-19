export default function (el) {
  const options = Array.from(el.querySelectorAll('[data-ref="option"]'))
  if (options.length === 0) return

  const supportsHover = window.matchMedia('(hover: hover) and (pointer: fine)').matches
  const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches

  const activate = (option) => {
    if (option.classList.contains('active')) return
    options.forEach(opt => opt.classList.remove('active'))
    option.classList.add('active')
  }

  const onClick = (e) => {
    activate(e.currentTarget)
  }

  const onMouseEnter = (e) => {
    activate(e.currentTarget)
  }

  const onKeydown = (e) => {
    if (e.target !== e.currentTarget) return
    if (e.key === 'Enter' || e.key === ' ') {
      e.preventDefault()
      activate(e.currentTarget)
    }
  }

  // Holo Card: only visible (via CSS, gated on .active:hover) once a card is
  // already expanded, so this just keeps the pointer position ready for it.
  const onPointerMove = (e) => {
    const option = e.currentTarget
    const rect = option.getBoundingClientRect()
    const x = (e.clientX - rect.left) / rect.width
    const y = (e.clientY - rect.top) / rect.height

    option.style.setProperty('--expanding-cards-mx', `${x * 100}%`)
    option.style.setProperty('--expanding-cards-my', `${y * 100}%`)
  }

  options.forEach(option => {
    option.addEventListener('click', onClick)
    option.addEventListener('keydown', onKeydown)
    if (supportsHover) {
      option.addEventListener('mouseenter', onMouseEnter)
    }
    if (supportsHover && !reducedMotion) {
      option.addEventListener('pointermove', onPointerMove)
    }
  })

  return () => {
    options.forEach(option => {
      option.removeEventListener('click', onClick)
      option.removeEventListener('keydown', onKeydown)
      if (supportsHover) {
        option.removeEventListener('mouseenter', onMouseEnter)
      }
      if (supportsHover && !reducedMotion) {
        option.removeEventListener('pointermove', onPointerMove)
      }
    })
  }
}
