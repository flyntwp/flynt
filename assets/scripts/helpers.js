export function buildRefs (el, customRefs) {
  return new Proxy(
    {},
    {
      get (target, prop) {
        if (!target[prop]) {
          const selector = customRefs[prop] ?? `[data-ref="${prop}"]`
          target[prop] = el.querySelector(selector)
          if (!target[prop]) {
            throw new Error(`ref ${prop} not found.`)
          }
        }
        return target[prop]
      }
    }
  )
}

export function getJSON (node, selector = 'script[type="application/json"]', property = 'textContent') {
  let data = {}
  try {
    data = JSON.parse(node.querySelector(selector)[property])
  } catch (e) {}
  return data
}
