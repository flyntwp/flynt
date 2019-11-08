import jQuery from 'jquery'

(function ($) {
  const o = $({})

  $.subscribe = function () {
    o.on.apply(o, arguments)
  }

  $.subscribeOnce = function () {
    o.one.apply(o, arguments)
  }

  $.unsubscribe = function () {
    o.off.apply(o, arguments)
  }

  $.publish = function () {
    o.trigger.apply(o, arguments)
  }
}(jQuery))
