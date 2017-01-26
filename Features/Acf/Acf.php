<?php

namespace Flynt\Features;

require_once __DIR__ . '/FieldGroupComposer.php';
require_once __DIR__ . '/OptionPages.php';
require_once __DIR__ . '/Loader.php';

use Flynt\Features\Acf\Loader;
use Flynt\Utils\Feature;

class Acf extends Feature {

  public function setup() {
    Loader::setup($this->getOption(0));
  }

  public function init() {
    Loader::init();
  }
}
