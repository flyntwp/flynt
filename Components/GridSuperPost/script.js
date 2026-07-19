const POINTER_TRACKING_STYLES = ['tilt3d', 'holo', 'glassmorphism']

export default function (el) {
  const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches
  if (reducedMotion) return

  // Each card can have its own hover style (falling back to the grid-wide
  // default), so only the cards that actually need pointer tracking get it.
  const cards = Array.from(el.querySelectorAll('[data-ref="card"]'))
    .filter(card => POINTER_TRACKING_STYLES.includes(card.dataset.hover))
  if (cards.length === 0) return

  const onPointerMove = (e) => {
    const card = e.currentTarget
    const rect = card.getBoundingClientRect()
    const x = (e.clientX - rect.left) / rect.width
    const y = (e.clientY - rect.top) / rect.height

    card.style.setProperty('--grid-super-post-mx', `${x * 100}%`)
    card.style.setProperty('--grid-super-post-my', `${y * 100}%`)
    card.style.setProperty('--grid-super-post-rx', `${(x - 0.5) * 18}deg`)
    card.style.setProperty('--grid-super-post-ry', `${(0.5 - y) * 18}deg`)
  }

  const onPointerLeave = (e) => {
    const card = e.currentTarget
    card.style.removeProperty('--grid-super-post-mx')
    card.style.removeProperty('--grid-super-post-my')
    card.style.removeProperty('--grid-super-post-rx')
    card.style.removeProperty('--grid-super-post-ry')
  }

  cards.forEach(card => {
    card.addEventListener('pointermove', onPointerMove)
    card.addEventListener('pointerleave', onPointerLeave)
  })

  return () => {
    cards.forEach(card => {
      card.removeEventListener('pointermove', onPointerMove)
      card.removeEventListener('pointerleave', onPointerLeave)
    })
  }
}
