/* globals acf jQuery */

(function ($) {
  const setUpInputVal = function () {
    return new acf.Model({
      wait: 'ready',
      initialize: function () {
        const $blockAnchor = $('[data-layout="blockAnchor"]:not(.acf-clone)')
        if ($blockAnchor.length > 0) {
          $blockAnchor.find('input[name*=blockAnchor_anchor]').each(function (i, el) {
            const $el = $(el)
            changeText($el, $el.val())
          })
        }
      }
    })
  }

  const onChangeText = function (e, $el) {
    const $blockAnchor = $el.closest('[data-layout="blockAnchor"]:not(.acf-clone)')
    if ($blockAnchor.length > 0) {
      changeText($(e.currentTarget), $el.val())
    }
  }

  const changeText = function ($el, val) {
    const $blockAnchor = $el.closest('[data-layout="blockAnchor"]:not(.acf-clone)')
    const $anchorLink = $blockAnchor.find('.flyntAnchorLinkCopy')
    if ($anchorLink) {
      const $anchorLinkInput = $anchorLink.find('input[type="text"]')
      $anchorLinkInput.attr('tabindex', '-1')
      const href = $anchorLinkInput.data('href')
      val = sanitiseText(val)
      const link = `${href}#${val}`
      $anchorLinkInput.val(link)
    }
  }

  const sanitiseText = function (value) {
    // convert to lowercase letters only
    value = value.replace(/[^A-Za-z]/g, '').toLowerCase()

    return value
  }

  const selectText = function (e, $el) {
    $el.select()
  }

  const copyToClipboard = function (e, $el) {
    e.preventDefault()
    const $anchorField = $el.closest('[data-layout="blockAnchor"]:not(.acf-clone)')
    if ($anchorField.length > 0) {
      const $anchorLinkInput = $anchorField.find('.flyntAnchorLinkCopy-input')
      const $copyMessage = $anchorField.find('.flyntAnchorLinkCopy-message')
      $anchorLinkInput.select()
      document.execCommand('copy')
      $copyMessage.show().delay(5000).hide('fast')
    }
  }

  const initAcfEvents = function () {
    return new acf.Model({
      events: {
        'keyup input[name*=blockAnchor_anchor]': 'onChangeText',
        'click [data-copy-anchor-link]': 'copyToClipboard',
        'focus .flyntAnchorLinkCopy-input': 'selectText'
      },
      onChangeText,
      copyToClipboard,
      selectText
    })
  }

  if (typeof acf !== 'undefined') {
    setUpInputVal()
    initAcfEvents()
  }
})(jQuery)
