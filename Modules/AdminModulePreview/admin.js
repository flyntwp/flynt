/* globals wpData */
const $ = jQuery
let $body = $('body')
const ajaxCache = {}
// show module preview images
$body.on('mouseenter', 'a[data-layout]', function (e) {
  const $target = $(e.currentTarget)
  const layout = $target.data('layout')
  return showAddModulePreview(layout, $target.closest('.acf-fc-popup'))
})

// hide preview images
$body.on('mouseleave', 'a[data-layout]', function (e) {
  const $target = $(e.currentTarget)
  return hideAddModulePreview($target.closest('.acf-fc-popup'))
})

function showAddModulePreview (layout, $wrapper) {
  const moduleName = firstToUpperCase(layout)
  const image = {
    desktop: wpData.templateDirectoryUri + '/Modules/' + moduleName + '/preview-desktop.jpg',
    mobile: wpData.templateDirectoryUri + '/Modules/' + moduleName + '/preview-mobile.jpg'
  }
  const $wrapperContainer = $("<div class='add-module-preview-image-wrapper'>").appendTo($wrapper)

  cacheImage(image.desktop)
  ajaxCache[image.desktop].done(function () {
    $wrapperContainer.prepend(`<img class='add-module-preview-image add-module-preview-image-desktop' src='${image.desktop}'>`)
  })
  cacheImage(image.mobile)
  ajaxCache[image.mobile].done(function () {
    $wrapperContainer.append(`<img class='add-module-preview-image add-module-preview-image-mobile' src='${image.mobile}'>`)
  })
}

function cacheImage (image) {
  if (!ajaxCache[image]) {
    ajaxCache[image] = $.ajax({
      url: image
    })
  }
}

function hideAddModulePreview ($wrapper) {
  $wrapper.find('.add-module-preview-image-wrapper')
  .remove()
}

// collapse modules
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
// expand modules
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
