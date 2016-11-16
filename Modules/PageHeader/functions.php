<?php

add_filter('WPStarter/modifyModuleData?name=PageHeader', function($data, $parentData) {
  if(isset($parentData['currentQueriedObject'])) {
    $currentObject = $parentData['currentQueriedObject'];
    $data['title'] = $currentObject->post_title;
    $data['image'] = get_the_post_thumbnail($currentObject->ID);
  }
  return $data;
}, 10, 2);
