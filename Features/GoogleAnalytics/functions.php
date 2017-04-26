<?php

namespace Flynt\Features\GoogleAnalytics;

require_once __DIR__ . '/GoogleAnalytics.php';

use Flynt\Features\GoogleAnalytics\GoogleAnalytics;
use Flynt\Utils\Feature;
use Flynt\Features\Acf\OptionPages;

add_action('init', 'Flynt\Features\GoogleAnalytics\init', 100);

function init()
{
    $googleAnalyticsOptions = OptionPages::getOptions('globalOptions', 'feature', 'GoogleAnalytics');
    if ($googleAnalyticsOptions) {
        new GoogleAnalytics($googleAnalyticsOptions);
    }
}
