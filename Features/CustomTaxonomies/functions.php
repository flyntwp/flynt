<?php

namespace Flynt\Features\CustomTaxonomies;

require_once __DIR__ . '/CustomTaxonomyRegister.php';
require_once __DIR__ . '/Translator.php';

use Flynt\Utils\Feature;
use Flynt\Features\CustomTaxonomies\CustomTaxonomyRegister;

add_action('init', function () {
    $featureOptions = Feature::getOption('flynt-custom-taxonomies', 0);
    $dir = isset($featureOptions['dir']) ? $featureOptions['dir'] : null;
    $fileName = isset($featureOptions['fileName']) ? $featureOptions['fileName'] : null;

    CustomTaxonomyRegister::fromDir($dir, $fileName);
}, 11); // needs to happen before custom post types get added
