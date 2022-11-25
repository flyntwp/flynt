/* globals location, history */
import delegate from 'delegate-event-listener'

window.document.body.addEventListener('click', delegate('a[href*="#"]', onLinkClick))

if (location.hash) {
  smoothScrollTo(location.hash)
}

function onLinkClick (e) {
  const delegate = e.delegateTarget
  const currentURL = new URL(location)
  const linkURL = new URL(delegate.href)
  if (hrefWithoutHash(currentURL) === hrefWithoutHash(linkURL)) {
    e.preventDefault()
    smoothScrollTo(linkURL.hash)
    history.pushState({}, '', linkURL.href)
  }
}

function hrefWithoutHash (url) {
  return url.origin + url.pathname + url.search
}

function smoothScrollTo (selector) {
  const target = document.querySelector(selector)
  if (target) {
    target.scrollIntoView({ behavior: 'smooth' })
  }
}
