<?php

namespace Flynt\Features\CustomPostTypes;

require_once __DIR__ . '/CustomPostTypeRegister.php';
require_once __DIR__ . '/Translator.php';

use Flynt\Utils\Feature;
use Flynt\Features\CustomPostTypes\CustomPostTypeRegister;

/* NOTE: this needs to happen on init to allow taxonomies to register
 * acf/init happens on init with priority 5
 * in order to make sure custom post types are registered before acf fields
 * (e.g. for option pages) are added the priority needs to be lower than 5
 */
add_action('init', function () {
    $featureOptions = Feature::getOption('flynt-custom-post-types', 0);
    $dir = isset($featureOptions['dir']) ? $featureOptions['dir'] : null;
    $fileName = isset($featureOptions['fileName']) ? $featureOptions['fileName'] : null;

    CustomPostTypeRegister::fromDir($dir, $fileName);
}, 4);
