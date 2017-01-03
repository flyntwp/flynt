<?php

namespace Flynt\Features\CustomPostTypes;

require_once __DIR__ . '/CustomPostTypeRegister.php';

use Flynt\Utils\Feature;
use Flynt\Features\CustomPostTypes\CustomPostTypeRegister;

$dir = Feature::getOptions('flynt-custom-post-types')[0];
CustomPostTypeRegister::fromDirectory($dir);
