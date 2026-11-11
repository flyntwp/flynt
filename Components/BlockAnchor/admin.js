/* globals acf jQuery alert */

(function ($) {
  const setUpInputVal = function () {
    return new acf.Model({
      wait: 'ready',
      actions: {
        append: 'initialize'
      },
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
    const $anchorLinkInput = $blockAnchor.find('.anchorLink-url')
    if ($anchorLinkInput.length > 0) {
      const href = $anchorLinkInput.data('href')
      val = sanitizeText(val)
      const link = `${href}#${val}`
      $anchorLinkInput.text(link)
    }
  }

  const sanitizeText = function (value) {
    value = value.replace(/[^A-Za-z0-9]/g, '-').toLowerCase()
    return value
  }

  const copyToClipboard = function (e, $el) {
    e.preventDefault()
    const $anchorField = $el.closest('[data-layout="blockAnchor"]:not(.acf-clone)')
    if ($anchorField.length > 0) {
      const $anchorLinkInput = $anchorField.find('.anchorLink-url')
      const $copyMessage = $anchorField.find('.anchorLink-message')

      if (!navigator.clipboard) {
        const selection = window.getSelection()
        const range = document.createRange()
        range.selectNodeContents($anchorLinkInput[0])
        selection.removeAllRanges()
        selection.addRange(range)
        const copied = document.execCommand('copy')
        selection.removeAllRanges()
        if (copied) {
          $copyMessage.show().delay(5000).hide('fast')
        } else {
          alert('Oops! Something went wrong...')
        }
      } else {
        navigator.clipboard.writeText($anchorLinkInput.text()).then(
          function () {
            $copyMessage.show().delay(5000).hide('fast')
          })
          .catch(
            function () {
              alert('Oops! Something went wrong...')
            })
      }
    }
  }

  const initAcfEvents = function () {
    return new acf.Model({
      events: {
        'input input[name*=blockAnchor_anchor]': 'onChangeText',
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
