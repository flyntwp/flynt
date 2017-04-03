<?php

namespace Flynt\Components\ComponentLoaderFlexible;

use Flynt\Features\Acf\OptionPages;

add_filter('Flynt/addComponentData?name=ComponentLoaderFlexible', function ($data) {
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

add_filter('Flynt/dynamicSubcomponents?name=ComponentLoaderFlexible', function ($areas, $data, $parentData) {
    $fieldGroup = $data['fieldGroup'];
    if (array_key_exists($fieldGroup, $data) &&
        $data[$fieldGroup] !== false
    ) {
        $fieldGroupData = $data[$fieldGroup];
    } elseif (array_key_exists($fieldGroup, $parentData['post']->fields) &&
        $parentData['post']->fields[$fieldGroup] !== false
    ) {
        $fieldGroupData = $parentData['post']->fields[$fieldGroup];
    }
    if (isset($fieldGroupData)) {
        $areas['components'] = array_map(function ($field) use ($parentData) {
            return [
                'name' => ucfirst($field['acf_fc_layout']),
                'customData' => $field,
                'parentData' => $parentData // overwrite parent data of child components
            ];
        }, $fieldGroupData);
    }
    return $areas;
}, 10, 3);
