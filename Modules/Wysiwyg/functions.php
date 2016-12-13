<?php
namespace Flynt\Modules\Wysiwyg;

use Flynt\Helpers\Module;

add_action('wp_enqueue_scripts', function () {
  Module::enqueueAssets('Wysiwyg');
});

add_filter('Flynt/modifyModuleData?name=Wysiwyg', function ($data) {
  if (empty($data['theme'])) {
    $data['theme'] = get_field('defaultTheme', 'options');
  }
  return $data;
});
