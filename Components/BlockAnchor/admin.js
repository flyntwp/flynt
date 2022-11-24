/* globals acf jQuery alert */

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
    const $anchorLinkInput = $blockAnchor.find('.anchorLink-url')
    if ($anchorLinkInput) {
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
        document.execCommand('copy')
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
        'keyup input[name*=blockAnchor_anchor]': 'onChangeText',
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
