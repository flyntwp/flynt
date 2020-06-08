<?php

/**
 * Hide password protected posts from listings when using the loop or `get_posts`.
 */

namespace Flynt\HideProtectedPosts;

add_action('pre_get_posts', function ($query) {
    if (!$query->is_singular() && !is_admin()) {
        $query->set('has_password', false);
    }
});
