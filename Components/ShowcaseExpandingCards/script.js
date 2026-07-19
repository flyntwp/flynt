export default function (el) {
  const options = Array.from(el.querySelectorAll('[data-ref="option"]'))
  if (options.length === 0) return

  const supportsHover = window.matchMedia('(hover: hover) and (pointer: fine)').matches

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

  options.forEach(option => {
    option.addEventListener('click', onClick)
    option.addEventListener('keydown', onKeydown)
    if (supportsHover) {
      option.addEventListener('mouseenter', onMouseEnter)
    }
  })

  return () => {
    options.forEach(option => {
      option.removeEventListener('click', onClick)
      option.removeEventListener('keydown', onKeydown)
      if (supportsHover) {
        option.removeEventListener('mouseenter', onMouseEnter)
      }
    })
  }
}
