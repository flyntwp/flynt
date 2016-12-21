<?php

require_once __DIR__ . '/FieldGroupComposer.php';
require_once __DIR__ . '/OptionPages.php';
require_once __DIR__ . '/Loader.php';

use Flynt\Features\Acf\Loader;

// TODO get options from static wrapper object instead
Loader::init([
  'FieldGroupComposer',
  'OptionPages'
]);
