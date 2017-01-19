<?php

namespace Flynt\Features\CustomPostTypes;

require_once __DIR__ . '/CustomPostTypeRegister.php';

use Flynt\Utils\Feature;
use Flynt\Features\CustomPostTypes\CustomPostTypeRegister;

$featureOptions = Feature::getOptions('flynt-custom-post-types')[0];
$dir = isset($featureOptions['directory']) ? $featureOptions['directory'] : null;
$fileName = isset($featureOptions['fileName']) ? $featureOptions['fileName'] : null;

CustomPostTypeRegister::fromDirectory($dir, $fileName);
