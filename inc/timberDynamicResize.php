<?php

namespace Flynt\TimberDynamicResize;

use Flynt\Utils\Options;
use Flynt\Utils\TimberDynamicResize;

add_filter(
    'acf/load_field/key=field_global_TimberDynamicResize_relativeUploadPath',
    function ($field) {
        $field['placeholder'] = TimberDynamicResize::getDefaultRelativeUploadDir();
        return $field;
    }
);

add_filter(
    'update_option_options_global_TimberDynamicResize_dynamicImageGeneration', function () {
        flush_rewrite_rules(false);
    }
);

add_filter(
    'update_option_options_global_TimberDynamicResize_webpSupport', function () {
        flush_rewrite_rules(true);
    }
);

add_filter(
    'update_option_options_global_TimberDynamicResize_relativeUploadPath', function () {
        flush_rewrite_rules(false);
    }
);

add_action('acf/init', function () {
    new TimberDynamicResize();
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
        'label' => 'WebP Support',
        'name' => 'webpSupport',
        'type' => 'true_false',
        'default_value' => 1,
        'ui' => true,
        'instructions' => 'Generate additional .webp images.',
    ],
    [
        'label' => 'Relative Upload Path',
        'name' => 'relativeUploadPath',
        'type' => 'text',
        'instructions' => 'If Flynt cannot determine the path of your uploads directory relative to the docroot, use this to set it manually.',
    ],
]);
