<?php

/**
 * Removes `the_content` area (editor) from the Wordpress backend, since Flynt uses ACF.
 */

namespace Flynt\RemoveEditor;

add_action('init', function () {
    remove_post_type_support('page', 'editor');
    remove_post_type_support('post', 'editor');
});
