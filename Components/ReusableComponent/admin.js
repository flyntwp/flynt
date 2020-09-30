/* globals acf */
import $ from 'jquery'

acf.addAction('select2_init', function ($select, args, settings, field) {
  const $fieldEl = field.$el

  $select.on('change', { $fieldEl: $fieldEl }, function () {
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
})
