/* globals wpData */
import 'file-loader?name=vendor/draggabilly.js!draggabilly/dist/draggabilly.pkgd'

// admin
if ($('body.wp-admin').length) {
  $('body').on('mouseenter', 'a[data-layout]', function (e) {
    let $target = $(e.currentTarget)
    let layout = $target.data('layout')
    return showAddModulePreview(layout, $target.closest('.acf-fc-popup'))
  })

  $('body').on('mouseleave', 'a[data-layout]', function (e) {
    let $target = $(e.currentTarget)
    return hideAddModulePreview($target.closest('.acf-fc-popup'))
  })

  $('body')
  .on('click', '.acf-label .collapse-all, .acf-th-flexible_content .collapse-all', e =>
    $(e.currentTarget)
    .closest('.acf-field')
    .closestChild('.values')
    .children('.layout:not(.-collapsed)')
    .children('.acf-fc-layout-controlls')
    .find('[data-event="collapse-layout"]')
    .click()
  )
  .on('click', '.acf-label .expand-all, .acf-th-flexible_content .expand-all', e =>
    $(e.currentTarget)
    .closest('.acf-field')
    .closestChild('.values')
    .children('.layout.-collapsed')
    .children('.acf-fc-layout-controlls')
    .find('[data-event="collapse-layout"]')
    .click()
  )

  var showAddModulePreview = function (layout, $wrapper) {
    var moduleName = firstToUpperCase(layout)
    var image
    image = {
      desktop: wpData.templateDirectoryUri + '/Modules/' + moduleName + '/preview-desktop.jpg',
      mobile: wpData.templateDirectoryUri + '/Modules/' + moduleName + '/preview-mobile.jpg'
    }
    let $wrapperContainer = $("<div class='add-module-preview-image-wrapper'>").appendTo($wrapper)
    $.ajax({
      url: image.desktop
    }).done(function () {
      $wrapperContainer.append(`<img class='add-module-preview-image add-module-preview-image-desktop' src='${image.desktop}'>`)
    })
    $.ajax({
      url: image.mobile
    }).done(function () {
      $wrapperContainer.append(`<img class='add-module-preview-image add-module-preview-image-mobile' src='${image.mobile}'>`)
    })
  }

  var hideAddModulePreview = $wrapper =>
  $wrapper.find('.add-module-preview-image-wrapper')
  .remove()
} else if ($('html.logged-in ').length) {
  // front-end logged in
  let $mpc = null
  let $activeImage = []

  var getModuleImages = function (output = {}) {
    $('.main-content [is]').each(function () {
      var moduleString = $(this).attr('is')
      var moduleName = $.camelCase(moduleString.substring(moduleString.indexOf('-') + 1))
      moduleName = firstToUpperCase(moduleName)
      var images
      images = {
        desktop: wpData.templateDirectoryUri + '/Modules/' + moduleName + '/preview-desktop.jpg',
        mobile: wpData.templateDirectoryUri + '/Modules/' + moduleName + '/preview-mobile.jpg'
      }
      if (output[moduleName] == null) { output[moduleName] = images }
      addModulePreviews($(this), images)
    })
    return output
  }

  var addModulePreviews = function (module, images) {
    let $module = module
    let offset = $module.offset()

    let desktopImage = `<img class='module-preview-image module-preview-image-desktop' src='${images.desktop}'>`
    appendImage(desktopImage, offset)
    let mobileImage = `<img class='module-preview-image module-preview-image-mobile' src='${images.mobile}'>`
    appendImage(mobileImage, offset)
  }

  var appendImage = function (image, offset) {
    let $image = $(image)
    return $image
    .appendTo($mpc)
    .css({
      opacity: 0.7,
      position: 'absolute',
      zIndex: 9999,
      top: offset.top,
      left: offset.left
    })
    .on('error', function () {
      $image.remove()
    })
  }

  $('body')
  .on('click', '#wp-admin-bar-toggleModulePreviews', function (e) {
    e.preventDefault()
    let $target = $(e.currentTarget)
    $target.toggleClass('active')
    if ($target.hasClass('active')) {
      return showImages()
    } else {
      return hideImages()
    }
  })

  var showImages = function () {
    if (($mpc = $('#module-preview-container')).length) {
      $mpc.show()
    } else {
      $mpc = $('<div id="module-preview-container"></div>').appendTo('body')
      getModuleImages()
      initModulePreviewsDragEvents()
    }
    return $(window).on('keydown.moveModulePreviewImage', moveModulePreviewImage)
  }

  var hideImages = function () {
    $mpc.hide()
    return $(window).off('keydown.moveModulePreviewImage')
  }

  var initModulePreviewsDragEvents = function () {
    let $images = $('.module-preview-image')
    return $images.each(function () {
      var $draggable = $(this).draggabilly()
      $draggable.on('dragStart', function () {
        let maxZIndex = 0
        $images.each(function () {
          let zIndex = parseInt($(this).css('zIndex'), 10)
          if (zIndex > maxZIndex) { maxZIndex = zIndex }
        })
        $activeImage = $(this.element)
        return $activeImage.css('zIndex', maxZIndex + 1)
      })
    })
  }

  var moveModulePreviewImage = function (e) {
    e.preventDefault()
  }
}

let firstToUpperCase = function (str) {
  return str.substr(0, 1).toUpperCase() + str.substr(1)
}

;(function ($) {
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
})(window.jQuery)
