<?php

namespace Flynt\Components\FeatureGoogleAnalytics;

require_once __DIR__ . '/helpers.php';

use Flynt\Utils\Options;
use Timber\Loader;
use Flynt\Utils\TwigExtensionFlynt;
use Timber\Timber;

add_filter('Flynt/addComponentData?name=FeatureGoogleAnalytics', function ($data) {
    $googleAnalyticsOptions = Options::getGlobal('GoogleAnalytics');

    if ($googleAnalyticsOptions) {
        $data['jsonData'] = json_encode([
            'gaId' => $googleAnalyticsOptions['gaId'],
            'anonymizeIp' => $googleAnalyticsOptions['anonymizeIp'],
            'isTrackingEnabled' => isTrackingEnabled($googleAnalyticsOptions['gaId']),
            'isOptInComponentRegistered' => apply_filters('Flynt/BlockCookieOptIn', false),
        ]);
    }

    return $data;
});

$isActive = apply_filters('Flynt/BlockCookieOptIn', false);

if ($isActive) {
    Options::addTranslatable('GoogleAnalytics', [
        [
            'label' => 'Accept Google Analytics label',
            'name' => 'acceptGoogleAnalyticsLabel',
            'type' => 'text',
            'default_value' => 'Google Analytics Cookies',
            'required' => 1,
        ],
    ]);
}

add_action('wp_footer', function () {
    $loader = new Loader();
    $env = $loader->get_twig();
    $twig = new TwigExtensionFlynt();
    $context = Timber::get_context();
    echo $twig->renderComponent($env, $context, 'FeatureGoogleAnalytics');
});

add_filter('Flynt/thirdPartyCookies', function ($features) {
    $googleAnalyticsTranslatableOptions = Options::getTranslatable('GoogleAnalytics');

    $features = array_merge($features, [
        [
            'id' => 'GA_accept',
            'name' => 'GA_accept',
            'label' => $googleAnalyticsTranslatableOptions['acceptGoogleAnalyticsLabel'],
        ]
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
