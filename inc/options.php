<?php

namespace Flynt\Options;

use Flynt\Utils\Options;

add_filter('Flynt/addComponentData', function ($data, $componentName): array {
    // Get fields for this component.
    $options = array_reduce(array_keys(Options::OPTION_TYPES), function ($carry, $optionType) use ($componentName): array {
        return array_merge($carry, Options::get($optionType, $componentName));
    }, []);
    // Don’t overwrite existing data.
    return array_merge($options, $data);
}, 9, 2);
