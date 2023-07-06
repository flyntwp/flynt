<?php

namespace Flynt\Components\FeatureComponentName;

const FIELD_NAME = 'componentName';

add_action('admin_enqueue_scripts', function () {
    $data = [
        'fieldName' => FIELD_NAME,
        'labels' => [
            'placeholder' => __('Enter component name', 'flynt'),
            'tooltip' => __('Add component name', 'flynt'),
        ],
    ];
    wp_localize_script('Flynt/assets/admin', 'FeatureComponentName', $data);
});

// Add componentName field to all flexible content layouts
add_filter('ACFComposer/resolveEntity', function ($field) {
    if (isset($field['type']) && $field['type'] === 'flexible_content') {
        foreach ($field['layouts'] as $key => $layout) {
            $field['layouts'][$key]['sub_fields'][] = [
                'label' => '',
                'name' => FIELD_NAME,
                'type' => 'text',
                'wrapper' => [
                    'class' => 'hidden',
                ],
            ];
        }
    }
    return $field;
});
