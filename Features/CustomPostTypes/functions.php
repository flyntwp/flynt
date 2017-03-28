<?php

namespace Flynt\Features\CustomPostTypes;

require_once __DIR__ . '/CustomPostTypeRegister.php';

use Flynt\Utils\Feature;
use Flynt\Features\CustomPostTypes\CustomPostTypeRegister;

add_action('Flynt/afterRegisterFeatures', function () {

    $featureOptions = Feature::getOption('flynt-custom-post-types', 0);
    $dir = isset($featureOptions['dir']) ? $featureOptions['dir'] : null;
    $fileName = isset($featureOptions['fileName']) ? $featureOptions['fileName'] : null;

    CustomPostTypeRegister::fromDir($dir, $fileName);
});
