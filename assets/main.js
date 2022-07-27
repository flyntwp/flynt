import './scripts/publicPath'
import './scripts/loadCustomElements'
import { initFeatherIcons, addFeatherIconToListCheckCircle } from './scripts/helpersFeatherIcons'
import { kebabToCamel } from './scripts/helpers'
import { prepareAboveTheFoldLazyLoadedElements } from './scripts/PrepareAboveTheFold'
import 'normalize.css/normalize.css'
import './main.scss'

import loader from 'uce-loader'
import lazySizes from 'lazysizes'
import 'lazysizes/plugins/native-loading/ls.native-loading'

lazySizes.cfg.nativeLoading = { setLoadingAttribute: true, disableListeners: { scroll: true } }
prepareAboveTheFoldLazyLoadedElements()

document.addEventListener('DOMContentLoaded', function () {
  addFeatherIconToListCheckCircle()
  initFeatherIcons()
})
// Dynamic import component scripts
loader({
  container: document.body,

  async on (newTag) {
    const componentName = kebabToCamel(newTag).replace('Flynt', '')
    const componentSubpath = window.FlyntData.componentsWithScript[componentName]

    if (window.FlyntData.componentsWithScript[componentName]) {
      await import(`../Components/${componentSubpath}/script.js`)
    }
  }
})
