<?php

namespace Flynt\Components\ListComponents;

use Flynt\ComponentManager;
use Flynt\Utils\Component;
use Flynt\Utils\Asset;

add_filter('Flynt/addComponentData?name=ListComponents', function ($data) {
    Component::enqueueAssets('ListComponents');

    if (!empty($data['componentBlocks'])) {
        $data['componentBlocks'] = array_map(function ($block) {
            $componentPaths = explode('/', $block['component']);
            $block['component'] = implode('/', array_slice($componentPaths, count($componentPaths)-3, 3));

            if (file_exists(Asset::requirePath($block['component']."preview-desktop.jpg"))) {
                $block['componentPreviewDesktopUrl'] = Asset::requireUrl($block['component']."preview-desktop.jpg");
            }

            if (file_exists(Asset::requirePath($block['component']."preview-mobile.jpg"))) {
                $block['componentPreviewMobileUrl'] = Asset::requireUrl($block['component']."preview-mobile.jpg");
            }
            $readme = Asset::requirePath($block['component']."README.md");

            if (file_exists($readme)) {
                $block['readme'] = parsePreviewContent(file_get_contents($readme));
            }

            return $block;
        }, $data['componentBlocks']);
    }

    return $data;
});


add_filter('acf/load_field/name=component', function ($field) {
    $componentManager = ComponentManager::getInstance();
    $field['choices'] = array_flip($componentManager->getAll());
    return $field;
});

function parsePreviewContent($file)
{
    $content = [];
    $fields = preg_split('!\n---\s*\n*!', $file);
    foreach ($fields as $field) {
        $pos = strpos($field, ':');
        $key = str_replace(['-', ' '], '_', strtolower(trim(substr($field, 0, $pos))));
        if (empty($key)) {
            continue;
        }
        $content[$key] = trim(substr($field, $pos + 1));
        if ($key === 'text') {
            $content['html'] = $content[$key];
        }
    }
    return $content;
}
