<?php

namespace Flynt\Features\GoogleAnalytics;

require_once __DIR__ . '/GoogleAnalytics.php';

use Flynt\Features\GoogleAnalytics\GoogleAnalytics;
use Flynt\Utils\Feature;
use Flynt\Features\Acf\OptionPages;

add_action('Flynt/afterRegisterFeatures', 'Flynt\Features\GoogleAnalytics\init');

function init()
{
    $gaId = OptionPages::getOption('options', 'feature', 'GoogleAnalytics', 'gaId');
    $anonymizeIp = OptionPages::getOption('options', 'feature', 'GoogleAnalytics', 'anonymizeIp');
    $skippedUserRoles = OptionPages::getOption('options', 'feature', 'GoogleAnalytics', 'skippedUserRoles');
    $skippedIps = OptionPages::getOption('options', 'feature', 'GoogleAnalytics', 'skippedIps');
    if ($gaId) {
        new GoogleAnalytics($gaId, $anonymizeIp, $skippedUserRoles, $skippedIps);
    }
}
