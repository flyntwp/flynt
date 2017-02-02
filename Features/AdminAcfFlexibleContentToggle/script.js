const $ = jQuery
let $body = $('body')

// collapse components
$body
.on('click', '.acf-label .collapse-all, .acf-th-flexible_content .collapse-all', e =>
  $(e.currentTarget)
  .closest('.acf-field')
  .closestChild('.values')
  .children('.layout:not(.-collapsed)')
  .children('.acf-fc-layout-controlls')
  .find('[data-event="collapse-layout"]')
  .click()
)
// expand components
.on('click', '.acf-label .expand-all, .acf-th-flexible_content .expand-all', e =>
  $(e.currentTarget)
  .closest('.acf-field')
  .closestChild('.values')
  .children('.layout.-collapsed')
  .children('.acf-fc-layout-controlls')
  .find('[data-event="collapse-layout"]')
  .click()
)

$.fn.closestChild = function (selector) {
  let $children
  let $results
  $children = this.children()
  if ($children.length === 0) {
    return $()
  }
  $results = $children.filter(selector)
  if ($results.length > 0) {
    return $results
  } else {
    return $children.closestChild(selector)
  }
}
