<?php

namespace Flynt\Components\FeatureGoogleAnalytics;

require_once __DIR__ . '/GoogleAnalytics.php';

use Flynt\Components\FeatureGoogleAnalytics\GoogleAnalytics;
use Flynt\Utils\Options;

add_action('init', 'Flynt\Components\FeatureGoogleAnalytics\init');

function init()
{
    $googleAnalyticsOptions = Options::get('globalOptions', 'component', 'GoogleAnalytics');
    if ($googleAnalyticsOptions) {
        new GoogleAnalytics($googleAnalyticsOptions);
    }
}

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
        'ui_on_text' => '',
        'ui_off_text' => '',
        'message' => ''
    ],
    [
        'name' => 'skippedUserRoles',
        'label' => 'Skipped User Roles',
        'type' => 'checkbox',
        'choices' => [
            'administrator' => 'Administrator',
            'editor' => 'Editor',
            'author' => 'Author',
            'contributor' => 'Contributor',
            'subscriber' => 'Subscriber'
        ],
        'toggle' => 'All',
        'allow_custom' => 0,
        'save_custom' => 0,
        'layout' => 'vertical'
    ],
    [
        'name' => 'skippedIps',
        'label' => 'Skipped IPs',
        'type' => 'textarea',
        'maxlength' => 500,
        'placeholder' => 'Separate IP addresses with commas'
    ]
]);
