export function buildRefs (el) {
  return new Proxy(
    {},
    {
      get (target, prop) {
        if (!target[prop]) {
          target[prop] = el.querySelector(`[data-ref="${prop}"]`)
          if (!target[prop]) {
            throw `ref ${prop} not found.`
          }
        }
        return target[prop]
      }
    }
  )
}

export function getJSON(node, selector = 'script[type="application/json"]', property = 'textContent') {
  let data = {}
  try {
    data = JSON.parse(node.querySelector(selector)[property])
  } catch (e) {}
  return data
}
