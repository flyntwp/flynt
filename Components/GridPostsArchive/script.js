/* globals fetch, DOMParser */
import delegate from 'delegate-event-listener'
import { buildRefs } from '@/assets/scripts/helpers.js'

export default function (el) {
  const refs = buildRefs(el)

  el.addEventListener('click', delegate('[data-ref="loadMore"]', onLoadMore))

  async function onLoadMore (e) {
    e.preventDefault()

    const target = e.delegateTarget
    target.classList.add('button--disabled')

    const url = new URL(target.href)

    try {
      const response = await fetch(url)
      const responseAsText = await response.text()

      const parser = new DOMParser()
      const html = parser.parseFromString(responseAsText, 'text/html')
      const posts = html.querySelector('flynt-component[name="GridPostsArchive"] [data-ref="posts"]')
      const pagination = html.querySelector('flynt-component[name="GridPostsArchive"] [data-ref="pagination"]')

      refs.posts.append(...posts.children)

      refs.pagination.textContent = ''
      if (pagination) {
        refs.pagination.append(...pagination.children)
      }

      target.classList.remove('button--disabled')
    } catch (e) {
      console.error(e)
    }
  }
}
