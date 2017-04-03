<?php

namespace Flynt\Components\ComponentLoaderStatic;

use Flynt\Features\Acf\OptionPages;

add_filter('Flynt/addComponentData?name=ComponentLoaderStatic', function ($data) {
    $optionPage = (array_key_exists('optionPage', $data)) ? $data['optionPage'] : [];
    if (is_array($optionPage) &&
        array_key_exists('optionType', $optionPage) &&
        array_key_exists('optionCategory', $optionPage) &&
        array_key_exists('subPageName', $optionPage)
    ) {
        $options = OptionPages::getOptions(
            $optionPage['optionType'],
            $optionPage['optionCategory'],
            $optionPage['subPageName']
        );
        $data = array_merge($data, $options);
    }
    return $data;
});

add_filter('Flynt/dynamicSubcomponents?name=ComponentLoaderStatic', function ($areas, $data, $parentData) {
    if (!empty($areas['components'])) {
        $areas['components'] = array_map(function ($area) use ($data, $parentData) {
            $area['customData'] = isset($area['customData']) ? array_merge($area['customData'], $data) : $data;
            $area['parentData'] = isset($area['parentData']) ? array_merge($area['parentData'], $parentData) : $parentData;
            return $area;
        }, $areas['components']);
    }
    return $areas;
}, 10, 3);
