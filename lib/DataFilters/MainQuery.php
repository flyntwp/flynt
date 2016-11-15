<?php

add_filter('WPStarterTheme/DataFilters/MainQuery', function($data) {
  $currentQueriedObject = get_queried_object();
  if(!is_null($currentQueriedObject))
    $data['currentQueriedObject'] = $currentQueriedObject;

  return $data;
});
