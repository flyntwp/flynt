/* globals acf jQuery */

(function ($) {
  const select2init = function () {
    acf.addAction('select2_init', function ($select, args, settings, field) {
      const $fieldEl = field.$el

      if ($fieldEl.data('name') === 'reusableComponent') {
        $select.on('change', { $fieldEl }, function () {
          const postId = $(this).val()
          const postTitle = $(this).find('option:selected').text()
          const $postLink = $fieldEl.find('.reusable-postLink')
          const oldPostId = $postLink.attr('data-postId')
          const $hiddenEl = $fieldEl.find('[hidden]')
          const href = $postLink.attr('href')

          $hiddenEl.removeAttr('hidden')
          $postLink.text(postTitle)
          $postLink.attr('data-postId', postId)
          $postLink.attr('href', href.replace(oldPostId, postId))
        })
      }
    })
  }

  if (typeof acf !== 'undefined') {
    select2init()
  }
})(jQuery)
