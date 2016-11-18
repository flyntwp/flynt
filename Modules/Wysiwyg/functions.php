<?php

add_filter('WPStarter/modifyModuleData?name=Wysiwyg', function ($data, $parentData) {
  if (isset($parentData['currentQueriedObject'])) {
    $currentObject = $parentData['currentQueriedObject'];
    $data['content'] = $currentObject->post_content; // @codingStandardsIgnoreLine
  }
  return $data;
}, 10, 2);
