<?php

namespace Flynt\Components\FeatureAdminComponentSearch;

add_action('admin_enqueue_scripts', function () {
    $data = [
        'labels' => [
            'placeholder' => __('Search...', 'flynt'),
            'noResults' => __('No components found', 'flynt'),
        ],
    ];
    wp_localize_script('Flynt/assets/admin', 'FeatureAdminComponentSearch', $data);
});
