import 'vite/modulepreload-polyfill'
import './scripts/loadCustomElements'
import { prepareAboveTheFoldLazyLoadedElements } from './scripts/prepareAboveTheFold'
import FlyntComponent from './scripts/FlyntComponent'

import lazySizes from 'lazysizes'
import 'lazysizes/plugins/native-loading/ls.native-loading'

if (import.meta.env.DEV) {
  import('@vite/client')
}

lazySizes.cfg.nativeLoading = { setLoadingAttribute: true, disableListeners: { scroll: true } }
prepareAboveTheFoldLazyLoadedElements()

window.customElements.define(
  'flynt-component',
  FlyntComponent
)

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
