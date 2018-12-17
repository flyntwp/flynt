<?php

namespace Flynt\Components\BlockBaseStyle;

use Flynt\Utils\Component;
use Flynt;

add_filter('Flynt/addComponentData?name=BlockBaseStyle', function ($data) {
    Component::enqueueAssets('BlockBaseStyle');
    return $data;
});

Flynt\registerFields('BlockBaseStyle', [
    'layout' => [
        'name' => 'blockBaseStyle',
        'label' => 'Block: BaseStyle',
    ],
]);
