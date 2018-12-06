<?php

namespace Flynt\Components\GridDownloadPortrait;

use Flynt\Features\Components\Component;

add_filter('Flynt/addComponentData?name=GridDownloadPortrait', function ($data) {
    add_action('wp_enqueue_scripts', function () {
        Component::enqueueAssets('GridDownloadPortrait', [
            [
                'name' => 'lazysizes-object-fit',
                'type' => 'script',
                'path' => 'vendor/lazysizes-object-fit.js'
            ],
            [
                'name' => 'lazysizes-parent-fit',
                'type' => 'script',
                'path' => 'vendor/lazysizes-parent-fit.js'
            ],
            [
                'name' => 'lazysizes',
                'type' => 'script',
                'path' => 'vendor/lazysizes.js'
            ]
        ]);
    });

    if (!empty($data['items'])) {
        $data['items'] = array_map(function ($item) {
            if ($item['itemType'] === 'itemFile') {
                $fileSize = filesize(get_attached_file($item['file']['id']));
                $item['file']['fileSize'] = size_format($fileSize, 2);
            } else {
                $pattern = '/\w+\..{2,3}(?:\..{2,3})?(?:$|(?=\/))/i';
                if (preg_match($pattern, $item['link'], $matches) === 1) {
                    $item['domain'] = $matches[0];
                }
            }
            return $item;
        }, $data['items']);
    }

    return $data;
});
