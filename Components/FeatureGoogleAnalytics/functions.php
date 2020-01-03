<?php

namespace Flynt\Components\FeatureGoogleAnalytics;

use Flynt\Utils\Options;
use Timber\Timber;

function isTrackingEnabled($gaId)
{
    if ($gaId) {
        $user = wp_get_current_user();
        $trackingEnabled = $gaId === 'debug' || !in_array('administrator', $user->roles);
        return $trackingEnabled;
    }
    return false;
}

add_filter('Flynt/addComponentData?name=FeatureGoogleAnalytics', function ($data) {
    $googleAnalyticsOptions = Options::getGlobal('GoogleAnalytics');

    if ($googleAnalyticsOptions) {
        $isTrackingEnabled = isTrackingEnabled($googleAnalyticsOptions['gaId']);
        $data['jsonData'] = json_encode([
            'gaId' => $googleAnalyticsOptions['gaId'],
            'anonymizeIp' => $googleAnalyticsOptions['anonymizeIp'],
            'isOptInComponentRegistered' => did_action('Flynt/thirdPartyCookies/initializeOptions'),
            'cookieType' => 'statistics',
        ]);
        $data['isTrackingEnabled'] = $isTrackingEnabled;
    }

    return $data;
});

add_action('wp_footer', function () {
    $context = Timber::get_context();
    Timber::render_string('{{ renderComponent("FeatureGoogleAnalytics") }}', $context);
});

add_filter('Flynt/thirdPartyCookies', function ($features) {
    $features = array_merge($features, [
        'statistics' => [
            'id' => 'statistics',
            'label' => 'Statistics',
            'name' => 'statistics',
        ],
    ]);
    return $features;
});

Options::addGlobal('GoogleAnalytics', [
    [
        'name' => 'gaId',
        'label' => 'Google Analytics ID',
        'type' => 'text',
        'maxlength' => 20,
        'prepend' => '',
        'append' => '',
        'placeholder' => 'XX-XXXXXXXX-X',
        'instructions' => 'You can enter \'debug\' to activate debug mode. It will only log to console and overwrite all other settings.'
    ],
    [
        'name' => 'anonymizeIp',
        'label' => 'Anonymize IP',
        'type' => 'true_false',
        'ui' => 'no',
        'default' => 1,
        'ui_on_text' => 'Yes',
        'ui_off_text' => 'No',
        'message' => ''
    ],
]);
