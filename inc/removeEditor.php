<?php
/**
 * Removes `the_content` area (editor) from the Wordpress backend. Since Flynt uses ACF by default, this area is not needed. If you need to use this editor in your project, simply remove the `add_theme_support('flynt-remove-editor')` line from your `lib/Init.php` file.
 */
namespace Flynt\RemoveEditor;

use Flynt\Defaults;

add_action('init', function () {
    if (!Defaults::$useGutenberg) {
        remove_post_type_support('page', 'editor');
        remove_post_type_support('post', 'editor');
    }
});
