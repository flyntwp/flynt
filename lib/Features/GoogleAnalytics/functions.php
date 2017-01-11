<?php

namespace Flynt\Features\GoogleAnalytics;

use Flynt\Utils\Feature;

require_once __DIR__ . '/GoogleAnalytics.php';

$gaId = Feature::getOptions('flynt-google-analytics')[0];
new GoogleAnalytics($gaId);
