<?php

namespace Flynt\Features\GoogleAnalytics;

require_once __DIR__ . '/GoogleAnalytics.php';

use Flynt\Features\GoogleAnalytics\GoogleAnalytics;
use Flynt\Utils\Options;

add_action('init', 'Flynt\Features\GoogleAnalytics\init');

function init()
{
    $googleAnalyticsOptions = Options::get('globalOptions', 'feature', 'GoogleAnalytics');
    if ($googleAnalyticsOptions) {
        new GoogleAnalytics($googleAnalyticsOptions);
    }
}
