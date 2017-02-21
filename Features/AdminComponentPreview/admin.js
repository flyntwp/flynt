/* globals wpData */
const helper = require('./helper')
const $ = jQuery
const $body = $('body')
const ajaxCache = {}
// show component preview images
$body.on('mouseenter', 'a[data-layout]', function (e) {
  const $target = $(e.currentTarget)
  const layout = $target.data('layout')
  showComponentPreview(layout, $target.closest('.acf-fc-popup'))
})

// hide preview images
$body.on('mouseleave', 'a[data-layout]', function (e) {
  const $target = $(e.currentTarget)
  hideComponentPreview($target.closest('.acf-fc-popup'))
})

function showComponentPreview (layout, $wrapper) {
  const componentName = helper.firstToUpperCase(layout)
  const image = {
    desktop: wpData.templateDirectoryUri + '/Components/' + componentName + '/preview-desktop.jpg',
    mobile: wpData.templateDirectoryUri + '/Components/' + componentName + '/preview-mobile.jpg'
  }
  const $wrapperContainer = $("<div class='add-component-preview-image-wrapper'>").appendTo($wrapper)

  getImage(image.desktop).done(function () {
    $wrapperContainer.prepend(`<img class='add-component-preview-image add-component-preview-image-desktop' src='${image.desktop}'>`)
  })

  getImage(image.mobile).done(function () {
    $wrapperContainer.append(`<img class='add-component-preview-image add-component-preview-image-mobile' src='${image.mobile}'>`)
  })
}

function getImage (image) {
  if (!ajaxCache[image]) {
    ajaxCache[image] = $.ajax({
      url: image
    })
  }
  return ajaxCache[image]
}

function hideComponentPreview ($wrapper) {
  $wrapper.find('.add-component-preview-image-wrapper')
  .remove()
}
