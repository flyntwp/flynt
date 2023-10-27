<?php

namespace Flynt\Components\FeatureStudio;

require_once __DIR__ . '/route.php';

if (is_admin()) {
    require_once __DIR__ . '/admin.php';
}
