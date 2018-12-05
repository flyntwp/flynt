<?php
namespace Flynt\Components\BlockCookieNotice;

use Flynt\Features\Acf\OptionPages;
use Flynt\Features\Components\Component;

add_filter('Flynt/addComponentData?name=BlockCookieNotice', function ($data) {
    add_action('wp_enqueue_scripts', function () {
        Component::enqueueAssets('BlockCookieNotice', [
            [
                'name' => 'js-cookie',
                'path' => 'vendor/js-cookie.js',
                'type' => 'script'
            ]
        ]);
    });

    if (!empty($data['expiryDays'])) {
        $expiryDays = (int) $data['expiryDays'];
    } else {
        $expiryDays = 7;
    }

    $data['json'] = [
        'expiryDays' => $expiryDays
    ];
    return $data;
});
