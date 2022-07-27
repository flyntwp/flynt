export function kebabToCamel (input) {
  return capitalize(input.replace(/-([a-z])/g, function (g) {
    return g[1].toUpperCase()
  }))
}

function capitalize (s) {
  if (typeof s !== 'string') return ''
  return s.charAt(0).toUpperCase() + s.slice(1)
}
