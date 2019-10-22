<?php

namespace Flynt\Components\GoogleAnalyticsOptIn;

use Flynt\Utils\Options;

require __DIR__ . '/fields.php';
require __DIR__ . '/helpers.php';

add_filter('Flynt/addComponentData?name=GoogleAnalyticsOptIn', function ($data) {
    $googleAnalyticsOptions = Options::get('globalOptions', 'component', 'GoogleAnalyticsAndOptInSettings');

    if ($googleAnalyticsOptions) {
        $data = array_merge($data, $googleAnalyticsOptions);
        $data['jsonData'] = json_encode([
            'gaId' => $googleAnalyticsOptions['gaId'],
            'expiryDays' => $googleAnalyticsOptions['expiryDays'],
            'serverSideTrackingEnabled' => isTrackingEnabled($googleAnalyticsOptions['gaId'], $googleAnalyticsOptions['skippedUserRoles'], $googleAnalyticsOptions['skippedIps'])
        ]);
    }

    return $data;
});
