<?php

namespace Flynt\TimberDynamicResize;

use Flynt\Utils\Options;
use Flynt\Utils\TimberDynamicResize;

global $timberDynamicResize;

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
    'update_option_options_global_TimberDynamicResize_webpSupport',
    function ($oldValue, $value) {
        global $timberDynamicResize;
        $timberDynamicResize->toggleWebp($value === '1');
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

add_action('acf/init', function () {
    global $timberDynamicResize;
    $timberDynamicResize = new TimberDynamicResize();
});

Options::addGlobal('TimberDynamicResize', [
    [
        'label' => 'Dynamic Image Generation',
        'name' => 'dynamicImageGeneration',
        'type' => 'true_false',
        'default_value' => 0,
        'ui' => true,
        'instructions' => 'Generate images on-the-fly, when requested, not during initial render.',
    ],
    [
        'label' => 'Relative Upload Path',
        'name' => 'relativeUploadPath',
        'type' => 'text',
        'instructions' => 'If Flynt cannot determine the path of your uploads directory relative to the docroot, use this to set it manually. This will not change the URL of the images, but rather help to fix 404 errors.',
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
    [
        'label' => 'WebP Support',
        'name' => 'webpSupport',
        'type' => 'true_false',
        'default_value' => 1,
        'ui' => true,
        'instructions' => 'Generate additional .webp images. Changing this will delete the "uploads/resize" folder.',
    ],
]);

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
