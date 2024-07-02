<?php

namespace Flynt\Options;

use Flynt\Utils\Options;

add_filter('Flynt/addComponentData', function ($data, $componentName): array {
    $options = array_reduce(array_keys(Options::OPTION_TYPES), function ($carry, $optionType) use ($componentName): array {
        return array_merge($carry, Options::get($optionType, $componentName));
    }, []);

    return array_merge($options, $data);
}, 9, 2);
