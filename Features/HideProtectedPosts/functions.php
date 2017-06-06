<?php

namespace Flynt\Features\HideProtectedPosts;

add_action('pre_get_posts', function ($query) {
    if (!$query->is_singular() && !is_admin()) {
        $query->set('has_password', false);
    }
});
