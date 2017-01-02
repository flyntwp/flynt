<?php

require_once __DIR__ . '/FieldGroupComposer.php';
require_once __DIR__ . '/OptionPages.php';
require_once __DIR__ . '/Loader.php';

use Flynt\Feature;
use Flynt\Features\Acf\Loader;

$options = Feature::getOptions('flynt-acf');
$helpers = is_array($options[0]) ? $options[0] : [];
Loader::init($helpers);
