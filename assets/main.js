import 'vite/modulepreload-polyfill'
import FlyntComponent from './scripts/FlyntComponent'
import { initIcons, addCustomAPIProviders, addCustomIcons } from './scripts/icons'

import 'lazysizes'

if (import.meta.env.DEV) {
  import('@vite/client')
}

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

window.customElements.define(
  'flynt-component',
  FlyntComponent
)

// addCustomAPIProviders()
addCustomIcons()
initIcons()
