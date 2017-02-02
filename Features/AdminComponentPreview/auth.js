/* globals wpData */
let $body = $('body')
let $container = null
let $activeImage = {}

$body
.on('click', '#wp-admin-bar-toggleComponentPreviews', function (e) {
  e.preventDefault()
  const $target = $(e.currentTarget)
  $target.toggleClass('active')
  if ($target.hasClass('active')) {
    showImages()
  } else {
    hideImages()
  }
})

function showImages () {
  if (($container = $('#component-preview-container')).length) {
    $container.show()
  } else {
    $container = $('<div id="component-preview-container"></div>').appendTo('body')
    getComponentImages()
    initComponentPreviewsDragEvents()
  }
  $(window).on('keydown.moveComponentPreviewImage', moveComponentPreviewImage)
}

function hideImages () {
  $container.hide()
  $(window).off('keydown.moveComponentPreviewImage')
}

function getComponentImages (output = {}) {
  $('.main-content [is]').each(function () {
    const componentString = $(this).attr('is')
    let componentName = $.camelCase(componentString.substring(componentString.indexOf('-') + 1))
    componentName = firstToUpperCase(componentName)
    const images = {
      desktop: wpData.templateDirectoryUri + '/Components/' + componentName + '/preview-desktop.jpg',
      mobile: wpData.templateDirectoryUri + '/Components/' + componentName + '/preview-mobile.jpg'
    }
    if (output[componentName] == null) { output[componentName] = images }
    addComponentPreviews($(this), images)
  })
}

function addComponentPreviews ($component, images) {
  const offset = $component.offset()
  const desktopImage = `<img class='component-preview-image component-preview-image-desktop' src='${images.desktop}'>`
  appendImage(desktopImage, offset, $component)
  const mobileImage = `<img class='component-preview-image component-preview-image-mobile' src='${images.mobile}'>`
  appendImage(mobileImage, offset, $component)
}

function appendImage (image, offset, $component) {
  const $image = $(image)
  $image
  .appendTo($container)
  .css({
    opacity: 0.7,
    position: 'absolute',
    zIndex: 9999,
    top: offset.top,
    left: offset.left
  })
  .data('component', $component)
  .on('error', function () {
    $image.remove()
  })
}

function initComponentPreviewsDragEvents () {
  const $images = $('.component-preview-image')
  $images.each(function () {
    const $draggable = $(this).draggabilly()
    $draggable.on('dragStart', function () {
      let maxZIndex = 0
      $images.each(function () {
        let zIndex = parseInt($(this).css('zIndex'), 10)
        if (zIndex > maxZIndex) { maxZIndex = zIndex }
      })
      $activeImage = $(this)
      $activeImage.css('zIndex', maxZIndex + 1)
    })
  })
}

function moveComponentPreviewImage (e) {
  e.preventDefault()
  const imageLeft = parseInt($activeImage.css('left'), 10)
  const imageTop = parseInt($activeImage.css('top'), 10)
  switch (e.which) {
    case 38: // up
      $activeImage.css('top', imageTop - 1)
      break
    case 39: // right
      $activeImage.css('left', imageLeft + 1)
      break
    case 40: // down
      $activeImage.css('top', imageTop + 1)
      break
    case 37: // left
      $activeImage.css('left', imageLeft - 1)
      break
  }
}

function repositionComponentPreviewImages () {
  const $images = $('.component-preview-image')
  $images.each(function () {
    const $component = $(this).data('component')
    $(this).css('top', $component.offset().top)
  })
}

$(window).on('resize', repositionComponentPreviewImages)

function firstToUpperCase (str) {
  return str.substr(0, 1).toUpperCase() + str.substr(1)
}
