<?php

namespace Flynt\TimberDynamicResize;

use Flynt\Utils\Options;
use Flynt\Utils\TimberDynamicResize;

add_action('acf/init', function () {
    global $timberDynamicResize;
    $timberDynamicResize = new TimberDynamicResize();
});

Options::addGlobal('TimberDynamicResize', [
    [
        'label' => __('Dynamic Image Generation', 'flynt'),
        'instructions' => __('Generate images on-the-fly, when requested, not during initial render.', 'flynt'),
        'name' => 'dynamicImageGeneration',
        'type' => 'true_false',
        'default_value' => 0,
        'ui' => true,
    ],
    [
        'label' => __('Relative Upload Path', 'flynt'),
        'instructions' => __('If Timber Dynamic Resize cannot resolve the path to images correctly, set the relative upload path manually.', 'flynt'),
        'name' => 'relativeUploadPath',
        'type' => 'text',
        'conditional_logic' => [
            [
                [
                    'fieldPath' => 'dynamicImageGeneration',
                    'operator' => '==',
                    'value' => '1'
                ]
            ]
        ]
    ],
]);

add_filter(
    'acf/load_field/key=field_global_TimberDynamicResize_relativeUploadPath',
    function ($field) {
        $field['placeholder'] = TimberDynamicResize::getDefaultRelativeUploadDir();
        return $field;
    }
);

add_action(
    'update_option_options_global_TimberDynamicResize_dynamicImageGeneration',
    function ($oldValue, $value) {
        global $timberDynamicResize;
        $timberDynamicResize->toggleDynamic($value === '1');
    },
    10,
    2
);

add_action(
    'update_option_options_global_TimberDynamicResize_relativeUploadPath',
    function ($oldValue, $value) {
        global $timberDynamicResize;
        $timberDynamicResize->changeRelativeUploadPath($value);
    },
    10,
    2
);

# WPML REWRITE FIX
add_filter('mod_rewrite_rules', function ($rules) {
    $homeRoot = parse_url(home_url());
    if (isset($homeRoot['path'])) {
        $homeRoot = trailingslashit($homeRoot['path']);
    } else {
        $homeRoot = '/';
    }

    $wpmlRoot = parse_url(get_option('home'));
    if (isset($wpmlRoot['path'])) {
        $wpmlRoot = trailingslashit($wpmlRoot['path']);
    } else {
        $wpmlRoot = '/';
    }

    $rules = str_replace("RewriteBase $homeRoot", "RewriteBase $wpmlRoot", $rules);
    $rules = str_replace("RewriteRule . $homeRoot", "RewriteRule . $wpmlRoot", $rules);

    return $rules;
});
