/* global IntersectionObserver, requestIdleCallback */
import './rIC.js'
const componentsWithScripts = import.meta.glob('@/Components/**/script.js')

const upgradedElements = new WeakMap()

export default class FlyntComponent extends window.HTMLElement {
  async connectedCallback () {
    const loadingStrategy = determineLoadingStrategy(this)
    const loadingFunctionWrapper = getLoadingFunctionWrapper(loadingStrategy, this)
    const mediaQuery = getMediaQuery(this)
    const loadingFunction = getLoadingFunction(this)

    if (mediaQuery) {
      await mediaQueryMatches(mediaQuery, this)
    }

    loadingFunctionWrapper(loadingFunction)
  }

  disconnectedCallback () {
    this.observer?.disconnect()
    this.mediaQueryList?.removeEventListener('change')
    cleanupElement(this)
  }
}

function visible (node) {
  return new Promise(function (resolve) {
    const observer = new IntersectionObserver(function (entries) {
      for (const entry of entries) {
        if (entry.isIntersecting) {
          observer.disconnect()
          resolve(true)
        }
      }
    })
    observer.observe(node)
    node.observer = observer
  })
}

function mediaQueryMatches (query, node) {
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
    node.mediaQueryList = mediaQueryList
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
    idle: (x) => requestIdleCallback(x, { timeout: 2000 }),
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
      if (typeof componentScript.default === 'function' && !upgradedElements.has(node)) {
        const cleanupFn = componentScript.default(node)
        upgradedElements.set(node, cleanupFn)
      }
    }
  }
}

function cleanupElement (node) {
  if (upgradedElements.has(node)) {
    const cleanupFn = upgradedElements.get(node)
    if (typeof cleanupFn === 'function') {
      cleanupFn(node)
    }
    upgradedElements.delete(node)
  }
}
