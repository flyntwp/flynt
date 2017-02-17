<?php

namespace Flynt\Components\NotFoundBlock;

use Flynt\Features\Components\Component;

add_action('wp_enqueue_scripts', function () {
  Component::enqueueAssets('NotFoundBlock');
});
