<?php

namespace Flynt\Features;

require_once __DIR__ . '/CustomPostTypeRegister.php';

use Flynt\Utils\Feature;
use Flynt\Features\CustomPostTypes\CustomPostTypeRegister;

class CustomPostTypes extends Feature {
  public function init() {
    $featureOptions = $this->getOption(0);
    $dir = isset($featureOptions['dir']) ? $featureOptions['dir'] : null;
    $fileName = isset($featureOptions['fileName']) ? $featureOptions['fileName'] : null;

    CustomPostTypeRegister::fromDir($dir, $fileName);
  }
}
