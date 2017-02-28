// name=[location in our vendor folder] ! [location in package folder]
import 'file-loader?name=vendor/normalize.css!csso-loader!normalize.css/normalize.css'

import { extractGetParams, buildQueryString } from './helper.js'

class NavigationFilter extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.sliderInitialised = false
    self.isMobile = false
    self.resolveElements()
    return self
  }

  resolveElements () {
    this.$categoryFilter = $('.filters-categoryFilter', this)
    this.$tagFilter = $('.filters-tagFilter', this)
    this.queryString = false
  }

  connectedCallback () {
    this.checkIfGetParamsExist()
    this.$categoryFilter.on('change', this.changeFilter.bind(this))
    this.$tagFilter.on('change', this.changeFilter.bind(this))
  }

  changeFilter () {
    const category = this.$categoryFilter.val()
    const tag = this.$tagFilter.val()
    let getParams = extractGetParams()

    getParams.category = category
    getParams.tag = tag

    const queryString = buildQueryString(getParams)
    let url = window.location.href.replace(window.location.search, '') + '?' + queryString
    const regex = /(\/page\/([0-9]*))/

    url = url.replace(regex, '')
    window.location = url
  }

  checkIfGetParamsExist () {
    if (window.location.search.indexOf('?') === 0) {
      this.queryString = window.location.search
    }
  }
}

window.customElements.define('flynt-navigation-filter', NavigationFilter, {extends: 'div'})
