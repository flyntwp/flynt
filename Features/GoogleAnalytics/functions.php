<?php

namespace Flynt\Features\GoogleAnalytics;

require_once __DIR__ . '/GoogleAnalytics.php';

use Flynt\Features\GoogleAnalytics\GoogleAnalytics;
use Flynt\Utils\Feature;

$id = Feature::getOption('flynt-google-analytics', 0);

new GoogleAnalytics($id);
