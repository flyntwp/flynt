import $ from 'jquery'

class GridPostsArchive extends window.HTMLDivElement {
  constructor (...args) {
    const self = super(...args)
    self.init()
    return self
  }

  init () {
    this.$ = $(this)
    this.resolveElements()
    this.bindFunctions()
    this.bindEvents()
  }

  resolveElements () {
    this.$posts = $('.posts', this)
    this.$pagination = $('.pagination', this)
  }

  bindFunctions () {
    this.onLoadMore = this.onLoadMore.bind(this)
  }

  bindEvents () {
    this.$.on('click', '[data-action="loadMore"]', this.onLoadMore)
  }

  onLoadMore (e) {
    e.preventDefault()

    const $target = $(e.currentTarget).addClass('button--disabled')

    const url = new URL(e.currentTarget.href)
    url.searchParams.append('contentOnly', 1)

    $.ajax({
      url: url
    }).then(
      response => {
        const $html = $(response)
        const $posts = $('.posts', $html)
        const $pagination = $('.pagination', $html)

        this.$posts.append($posts.html())
        this.$pagination.html($pagination.html() || '')
      },
      response => {
        console.error(response)
        $target.removeClass('button--disabled')
      }
    )
  }
}

window.customElements.define('flynt-grid-posts-archive', GridPostsArchive, { extends: 'div' })
