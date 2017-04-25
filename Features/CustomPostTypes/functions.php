<?php

namespace Flynt\Features\CustomPostTypes;

require_once __DIR__ . '/CustomPostTypeRegister.php';
require_once __DIR__ . '/Translator.php';

use Flynt\Utils\Feature;
use Flynt\Features\CustomPostTypes\CustomPostTypeRegister;

// NOTE: this needs to happen on init to allow taxonomies to register
add_action('init', function () {
    $featureOptions = Feature::getOption('flynt-custom-post-types', 0);
    $dir = isset($featureOptions['dir']) ? $featureOptions['dir'] : null;
    $fileName = isset($featureOptions['fileName']) ? $featureOptions['fileName'] : null;

    CustomPostTypeRegister::fromDir($dir, $fileName);
}, 12);
