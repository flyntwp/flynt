<?php

namespace Flynt\Components\ComponentLoaderStatic;

use Flynt\Features\Acf\OptionPages;

add_filter('Flynt/addComponentData?name=ComponentLoaderStatic', function ($data, $parentData) {
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
    } else if (isset($parentData['post'])) {
        $data = array_merge($data, $parentData['post']->fields);
    }
    return $data;
}, 10, 2);

add_filter('Flynt/dynamicSubcomponents?name=ComponentLoaderStatic', function ($areas, $data, $parentData) {
    if (!empty($areas['components'])) {
        $areas['components'] = array_map(function ($component) use ($data, $parentData) {
            if (isset($component['customData']) && isset($component['customData']['filterArgument'])) {
                $filterArgument = $component['customData']['filterArgument'] . '_';
                $componentData = [];
                foreach ($data as $key => $value) {
                    if (strrpos($key, $filterArgument) === 0) {
                        $componentData[substr($key, strlen($filterArgument))] = $data[$key];
                    }
                }
                $component['customData'] = array_merge($component['customData'], $componentData);
            } else {
                $component['customData'] = isset($component['customData']) ? array_merge($component['customData'], $data) : $data;
                $component['parentData'] = isset($component['parentData']) ? array_merge($component['parentData'], $parentData) : $parentData;
            }
            return $component;
        }, $areas['components']);
    }
    return $areas;
}, 10, 3);
