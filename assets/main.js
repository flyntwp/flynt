import 'vite/modulepreload-polyfill'
import './scripts/loadCustomElements'
import { prepareAboveTheFoldLazyLoadedElements } from './scripts/prepareAboveTheFold'

import loader from 'uce-loader'
import lazySizes from 'lazysizes'
import 'lazysizes/plugins/native-loading/ls.native-loading'

if (import.meta.env.DEV) {
  import('@vite/client')
}

lazySizes.cfg.nativeLoading = { setLoadingAttribute: true, disableListeners: { scroll: true } }
prepareAboveTheFoldLazyLoadedElements()

// Dynamic import component scripts
const componentsWithScripts = import.meta.glob('../Components/**/script.js')
loader({
  container: document.body,

  async on (newTag) {
    if (window.FlyntData.componentsWithScript[newTag]) {
      const componentName = window.FlyntData.componentsWithScript[newTag]
      componentsWithScripts[`../Components/${componentName}/script.js`]()
    }
  }
})

import.meta.glob([
  '../Components/**',
  '../assets/**',
  '!**/*.js',
  '!**/*.scss',
  '!**/*.php',
  '!**/*.twig',
  '!**/screenshot.png',
  '!**/*.md'
])
