export function buildRefs (el, multiple = false, customRefs = {}) {
  const QS = multiple ? 'querySelectorAll' : 'querySelector'
  const DA = multiple ? 'data-refs' : 'data-ref'
  return new Proxy(
    {},
    {
      get (target, prop) {
        if (!target[prop]) {
          const selector = customRefs[prop] ?? `[${DA}="${prop}"]`
          target[prop] = el[QS](selector)
          if (!target[prop]) {
            if (process.env.NODE_ENV !== 'production') {
              console.warn(`ref ${prop} not found.`)
            }
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
  } catch (e) { }
  return data
}
