/* globals fetch, DOMParser */
import { initFeatherIcons } from '../../assets/scripts/featherIcons'

class GridPostsArchive extends window.HTMLDivElement {
  constructor (...args) {
    const self = super(...args)
    self.init()
    return self
  }

  init () {
    this.resolveElements()
    this.bindFunctions()
    this.bindEvents()
  }

  resolveElements () {
    this.loadMore = this.querySelector('[data-action="loadMore"]')
    this.posts = this.querySelector('.posts')
    this.pagination = this.querySelector('.pagination')
  }

  bindFunctions () {
    this.onLoadMore = this.onLoadMore.bind(this)
  }

  bindEvents () {
    if (this.loadMore) {
      this.loadMore.addEventListener('click', this.onLoadMore)
    }
  }

  onLoadMore (e) {
    e.preventDefault()

    const target = e.currentTarget
    target.classList.add('button--disabled')

    const url = new URL(e.currentTarget.href)

    fetch(url)
      .then(response => {
        return response.text()
      }).then(responseAsText => {
        const parser = new DOMParser()
        const html = parser.parseFromString(responseAsText, 'text/html')
        const posts = html.querySelector('[is="flynt-grid-posts-archive"] .posts')
        const pagination = html.querySelector('[is="flynt-grid-posts-archive"] .pagination')

        if (posts) {
          this.posts.innerHTML += posts.innerHTML
          initFeatherIcons() // Init feather-icons inside the post item footer.
        }

        if (pagination) {
          const loadMore = pagination.querySelector('[data-action="loadMore"]')
          const targetUrl = new URL(loadMore.href)

          this.loadMore.href = targetUrl
        } else {
          this.pagination.innerHTML = ''
        }

        target.classList.remove('button--disabled')
      })
      .catch(err => {
        console.error(err)
      })
  }
}

window.customElements.define('flynt-grid-posts-archive', GridPostsArchive, { extends: 'div' })
