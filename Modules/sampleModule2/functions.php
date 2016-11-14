<?php
add_filter("WPStarter/dynamicSubmodules?name=sampleModule2", function($areas, $data, $parentData) {
  $areas['area51'] = [
    [
      'name' => 'sampleModule1',
      'customData' => [
        'headline' => 'Wow',
        'text' => 'hui'
      ]
    ]
  ];
  return $areas;
}, 10, 3);
