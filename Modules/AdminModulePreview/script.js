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
