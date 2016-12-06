/* globals wpData */
let $ = jQuery

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

  var showAddModulePreview = function (layout, $wrapper) {
    var moduleName = $.fn.firstToUpperCase(layout)
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
}

;(function ($) {
  $.fn.firstToUpperCase = function (str) {
    return str.substr(0, 1).toUpperCase() + str.substr(1)
  }
})(window.jQuery)
