/* globals acf jQuery */

(function ($) {
  const setUpInputVal = function () {
    return new acf.Model({
      wait: 'ready',
      initialize: function () {
        $('input[name*=field_pageComponents_pageComponents_blockAnchor_anchor]').each(function (i, el) {
          const $el = $(el)
          changeText($el, $el.val())
        })
      }
    })
  }

  const onChangeText = function (e, $el) {
    const $anchorField = $el.closest('[data-layout="blockAnchor"]')
    if ($anchorField.length > 0) {
      changeText($(e.currentTarget), $el.val())
    }
  }

  const changeText = function ($el, val) {
    const $blockAnchor = $el.closest('[data-layout="blockAnchor"]')
    const $anchorLink = $blockAnchor.find('.flyntAnchorLinkCopy')
    if ($anchorLink) {
      const $anchorLinkInput = $anchorLink.find('input[type="text"]')
      const href = $anchorLinkInput.data('href')
      const link = `${href}#${val}`
      $anchorLinkInput.val(link.toLowerCase())
    }
  }

  const copyToClipboard = function (e, $el) {
    e.preventDefault()
    const $anchorField = $el.closest('[data-layout="blockAnchor"]')
    if ($anchorField.length > 0) {
      const $anchorLinkInput = $anchorField.find('.flyntAnchorLinkCopy-input')
      $anchorLinkInput.select()
      document.execCommand('copy')
    }
  }

  const initAcfEvents = function () {
    return new acf.Model({
      events: {
        'keyup input[type="text"]': 'onChangeText',
        'click [data-copy-anchor-link]': 'copyToClipboard'
      },
      onChangeText,
      copyToClipboard
    })
  }

  if (typeof acf !== 'undefined') {
    setUpInputVal()
    initAcfEvents()
  }
})(jQuery)
