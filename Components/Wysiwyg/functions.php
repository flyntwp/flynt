<?php
namespace Flynt\Components\Wysiwyg;

use Flynt\Features\Components\Component;

add_action('wp_enqueue_scripts', function () {
  Component::enqueueAssets('Wysiwyg');
});
