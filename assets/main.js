// import './scripts/publicPath'
import './scripts/loadCustomElements'
import { initFeatherIcons, addFeatherIconToListCheckCircle } from './scripts/featherIcons'
import { prepareAboveTheFoldLazyLoadedElements } from './scripts/PrepareAboveTheFold'
import 'modern-normalize/modern-normalize.css'
import './main.scss'

import loader from 'uce-loader'
import lazySizes from 'lazysizes'
import 'lazysizes/plugins/native-loading/ls.native-loading'

lazySizes.cfg.nativeLoading = { setLoadingAttribute: true, disableListeners: { scroll: true } }
prepareAboveTheFoldLazyLoadedElements()

document.addEventListener('DOMContentLoaded', () => {
  addFeatherIconToListCheckCircle()
  initFeatherIcons()
})

// Dynamic import component scripts
loader({
  container: document.body,

  async on (newTag) {
    if (window.FlyntData.componentsWithScript[newTag]) {
      const componentName = window.FlyntData.componentsWithScript[newTag]
      import(`../Components/${componentName}/script.js`)
    }
  }
})
