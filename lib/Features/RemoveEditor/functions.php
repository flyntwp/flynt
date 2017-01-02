<?php

namespace Flynt\Features\RemoveEditor;

add_action('init', function () {
  remove_post_type_support('page', 'editor');
  remove_post_type_support('post', 'editor');
});
