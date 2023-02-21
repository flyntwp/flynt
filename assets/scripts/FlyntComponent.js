/* global IntersectionObserver, requestIdleCallback */
import './rIC.js'
const componentsWithScripts = import.meta.glob('@/Components/**/script.js')

const interactionEvents = new Set([
  'pointerdown',
  'scroll',
])

const upgradedElements = new WeakMap()
const FlyntComponents = new WeakMap()
const parents = new WeakMap()

export default class FlyntComponent extends window.HTMLElement {
  constructor () {
    super()
    let setReady
    const isReady = new Promise((resolve) => {
      setReady = resolve
    })
    FlyntComponents.set(this, [isReady, setReady])
  }
  async connectedCallback () {
    const loadingStrategy = determineLoadingStrategy(this)
    const loadingFunctionWrapper = getLoadingFunctionWrapper(loadingStrategy, this)
    const mediaQuery = getMediaQuery(this)
    const loadingFunction = getLoadingFunction(this)

    if (mediaQuery) {
      await mediaQueryMatches(mediaQuery, this)
    }

    if (this.hasParent()) {
      const [parentLoaded] = FlyntComponents.get(parents.get(this))
      await parentLoaded
    }

    loadingFunctionWrapper(loadingFunction)
  }

  hasParent () {
    if (!parents.has(this)) {
      const parent = this.parentElement.closest('flynt-component')
      parents.set(this, parent)
      return !!parent
    } else {
      return !!parents.get(this)
    }
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
  const defaultStrategy = 'load'
  const strategies = {
    load: 'load',
    idle: 'idle',
    visible: 'visible',
    interaction: 'interaction',
  }
  return strategies[node.getAttribute('load:on')] ?? defaultStrategy
}

function getLoadingFunctionWrapper (strategyName, node) {
  const loadingFunctions = {
    load: (x) => x(),
    idle: (x) => requestIdleCallback(x, { timeout: 2000 }),
    visible: async (x) => {
      await visible(node)
      x()
    },
    interaction: (x) => {
      const load = () => {
        interactionEvents.forEach((event) =>
          document.removeEventListener(event, load)
        )
        x()
      }
      interactionEvents.forEach((event) =>
        document.addEventListener(event, load, { once: true })
      )
    }
  }
  const defaultFn = loadingFunctions.load
  return loadingFunctions[strategyName] ?? defaultFn
}

function getMediaQuery (node) {
  return node.hasAttribute('load:on:media') ? node.getAttribute('load:on:media') : null
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
    const [_, setReady] = FlyntComponents.get(node)
    setReady()
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
