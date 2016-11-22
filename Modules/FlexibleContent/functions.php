<?php

add_filter('WPStarter/dynamicSubmodules?name=FlexibleContent', function ($areas, $data, $parentData) {
  $fieldGroup = $data['fieldGroup'];
  if (array_key_exists($fieldGroup, $parentData) && $parentData[$fieldGroup] !== false) {
    $areas['flexibleContent'] = array_map(function ($field) use ($parentData) {
      return [
        'name' => ucfirst($field['acf_fc_layout']),
        'customData' => $field,
        'parentData' => $parentData // overwrite parent data of child modules
      ];
    }, $parentData[$data['fieldGroup']]);
  }
  return $areas;
}, 10, 3);
