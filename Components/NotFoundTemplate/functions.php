<?php

namespace Flynt\Components\NotFoundTemplate;

use Flynt\Features\Components\Component;

add_action('wp_enqueue_scripts', function () {
  Component::enqueueAssets('NotFoundTemplate');
});
