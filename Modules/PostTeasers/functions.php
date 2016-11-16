<?php
add_filter('WPStarter/modifyModuleData?name=PostTeasers', function($data, $parentData) {
    $data['title'] = 'Teaser';
    return $data;
}, 10, 2);
