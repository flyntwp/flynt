<?php

/**
 * Add css styles to the block editor (Gutenberg).
 */

namespace Flynt\EditorAssets;

use Flynt\Utils\Asset;

add_action('enqueue_block_editor_assets', function () {
    wp_register_style('Flynt/assets/editor', Asset::requireUrl('assets/editor.scss'), [], null);
    wp_enqueue_style('Flynt/assets/editor');
});
