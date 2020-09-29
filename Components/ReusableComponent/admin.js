/* globals acf */
import $ from 'jquery'

acf.addAction('select2_init', function ($select, args, settings, field) {
  const $fieldEl = field.$el

  $select.on('change', { $fieldEl: $fieldEl }, function () {
    const postId = $(this).val()
    const postTitle = $(this).find('option:selected').text()
    const postLink = `/wp/wp-admin/post.php?post=${postId}&action=edit&classic-editor`
    const $postLink = $fieldEl.find('.reusable-postLink')

    if ($postLink.length > 0) {
      $postLink.text(postTitle)
      $postLink.attr('href', postLink)
    } else {
      $fieldEl.find('.description').html(`Edit <a class="reusable-postLink" href="${postLink}" target="_blank" rel="noopener noreferrer">${postTitle}</a>.`)
    }
  })
})
