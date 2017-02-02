/* globals wpData */
const $ = jQuery
let $body = $('body')
const ajaxCache = {}
// show component preview images
$body.on('mouseenter', 'a[data-layout]', function (e) {
  const $target = $(e.currentTarget)
  const layout = $target.data('layout')
  return showAddComponentPreview(layout, $target.closest('.acf-fc-popup'))
})

// hide preview images
$body.on('mouseleave', 'a[data-layout]', function (e) {
  const $target = $(e.currentTarget)
  return hideAddComponentPreview($target.closest('.acf-fc-popup'))
})

function showAddComponentPreview (layout, $wrapper) {
  const componentName = firstToUpperCase(layout)
  const image = {
    desktop: wpData.templateDirectoryUri + '/Components/' + componentName + '/preview-desktop.jpg',
    mobile: wpData.templateDirectoryUri + '/Components/' + componentName + '/preview-mobile.jpg'
  }
  const $wrapperContainer = $("<div class='add-component-preview-image-wrapper'>").appendTo($wrapper)

  getImage(image.desktop)
  ajaxCache[image.desktop].done(function () {
    $wrapperContainer.prepend(`<img class='add-component-preview-image add-component-preview-image-desktop' src='${image.desktop}'>`)
  })
  getImage(image.mobile)
  ajaxCache[image.mobile].done(function () {
    $wrapperContainer.append(`<img class='add-component-preview-image add-component-preview-image-mobile' src='${image.mobile}'>`)
  })
}

function getImage (image) {
  if (!ajaxCache[image]) {
    ajaxCache[image] = $.ajax({
      url: image
    })
  }
}

function hideAddComponentPreview ($wrapper) {
  $wrapper.find('.add-component-preview-image-wrapper')
  .remove()
}

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

function firstToUpperCase (str) {
  return str.substr(0, 1).toUpperCase() + str.substr(1)
}

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
