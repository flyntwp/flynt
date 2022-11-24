/* global IntersectionObserver, requestIdleCallback */
const componentsWithScripts = import.meta.glob('@/Components/**/script.js')

export default class FlyntComponent extends window.HTMLElement {
  async connectedCallback () {
    const loadingStrategy = determineLoadingStrategy(this)
    const loadingFunctionWrapper = getLoadingFunctionWrapper(loadingStrategy, this)
    const mediaQuery = getMediaQuery(this)
    const loadingFunction = getLoadingFunction(this)

    if (mediaQuery) {
      await mediaQueryMatches(mediaQuery)
    }

    loadingFunctionWrapper(loadingFunction)
  }
}

function visible (element) {
  return new Promise(function (resolve) {
    const observer = new IntersectionObserver(function (entries) {
      for (const entry of entries) {
        if (entry.isIntersecting) {
          observer.disconnect()
          resolve(true)
        }
      }
    })
    observer.observe(element)
  })
}

function mediaQueryMatches (query) {
  return new Promise(function (resolve) {
    const mediaQueryList = window.matchMedia(query)
    if (mediaQueryList.matches) {
      resolve(true)
    } else {
      mediaQueryList.addEventListener(
        'change',
        () => resolve(true),
        { once: true }
      )
    }
  })
}

function determineLoadingStrategy (node) {
  return node.hasAttribute('client:visible')
    ? 'visible'
    : (
        node.hasAttribute('client:idle')
          ? 'idle'
          : 'load'
      )
}

function getLoadingFunctionWrapper (strategyName, node) {
  const loadingFunctions = {
    load: (x) => x(),
    idle: (x) => requestIdleCallback(x),
    visible: async (x) => {
      await visible(node)
      x()
    }
  }
  const defaultFn = loadingFunctions.load
  return loadingFunctions[strategyName] ?? defaultFn
}

function getMediaQuery (node) {
  return node.hasAttribute('client:media') ? node.getAttribute('client:media') : null
}

function getLoadingFunction (node) {
  return async () => {
    const componentName = node.getAttribute('name')
    const componentPath = window.FlyntData.componentsWithScript[componentName]
    if (componentPath) {
      const componentScript = await componentsWithScripts[`/Components/${componentPath}/script.js`]()
      if (typeof componentScript.default === 'function') {
        componentScript.default(this)
      }
    }
  }
}
