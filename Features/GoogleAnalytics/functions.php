<?php

namespace Flynt\Features\GoogleAnalytics;

require_once __DIR__ . '/GoogleAnalytics.php';

use Flynt\Features\GoogleAnalytics\GoogleAnalytics;
use Flynt\Utils\Feature;
use Flynt\Features\Acf\OptionPages;

add_action('Flynt/afterRegisterFeatures', 'Flynt\Features\GoogleAnalytics\init');

// @codingStandardsIgnoreLine
function init() {
  $id = OptionPages::getOption('options', 'feature', 'GoogleAnalytics', 'gaId');
  $anonymizeIp = OptionPages::getOption('options', 'feature', 'GoogleAnalytics', 'anonymizeIp');
  $nonTrackedUsers = OptionPages::getOption('options', 'feature', 'GoogleAnalytics', 'nonTrackedUsers');
  if ($id) {
    new GoogleAnalytics($id, $anonymizeIp, $nonTrackedUsers);
  }
}
