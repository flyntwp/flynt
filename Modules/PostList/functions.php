<?php

add_filter('WPStarter/modifyModuleData?name=PostList', function($data) {
  return $data;
});
