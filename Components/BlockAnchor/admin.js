/* globals acf jQuery */

(function ($) {
  const setUpInputVal = function () {
    return new acf.Model({
      wait: 'ready',
      initialize: function () {
        const $blockAnchor = $('[data-layout="blockAnchor"]:not(.acf-clone)')
        if ($blockAnchor.length > 0) {
          $blockAnchor.find('input[name*=field_pageComponents_pageComponents_blockAnchor_anchor]').each(function (i, el) {
            const $el = $(el)
            const val = sanitiseText($el.val())
            $el.val(val)
            changeText($el, val)
          })
        }
      }
    })
  }

  const onChangeText = function (e, $el) {
    const $blockAnchor = $el.closest('[data-layout="blockAnchor"]:not(.acf-clone)')
    if ($blockAnchor.length > 0) {
      const val = sanitiseText($el.val())
      $el.val(val)
      changeText($(e.currentTarget), val)
    }
  }

  const changeText = function ($el, val) {
    const $blockAnchor = $el.closest('[data-layout="blockAnchor"]:not(.acf-clone)')
    const $anchorLink = $blockAnchor.find('.flyntAnchorLinkCopy')
    if ($anchorLink) {
      const $anchorLinkInput = $anchorLink.find('input[type="text"]')
      $anchorLinkInput.attr('tabindex', '-1')
      const href = $anchorLinkInput.data('href')
      const link = `${href}#${val}`
      $anchorLinkInput.val(link)
    }
  }

  const sanitiseText = function (value) {
    value = value.replace(/[^a-z]/g, '')

    return value
  }

  const copyToClipboard = function (e, $el) {
    e.preventDefault()
    const $anchorField = $el.closest('[data-layout="blockAnchor"]:not(.acf-clone)')
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
