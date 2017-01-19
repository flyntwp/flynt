<?php

namespace Flynt\Features\CustomPostTypes;

require_once __DIR__ . '/CustomPostTypeRegister.php';

use Flynt\Utils\Feature;
use Flynt\Features\CustomPostTypes\CustomPostTypeRegister;

$featureOptions = Feature::getOptions('flynt-custom-post-types');
$dir = $featureOptions[0];
$fileName = $featureOptions[1];
CustomPostTypeRegister::fromDirectory($dir, $fileName);
