<?php

namespace WPStarterTheme\Hooks;

use WPStarterTheme\Helpers\Utils;

// Enqueue Styles and Scripts
add_action('WPStarter/registerModule', function ($modulePath, $moduleName) {
  add_action('wp_enqueue_scripts', function () use ($modulePath, $moduleName) {
    $styleDeps = $moduleName === 'Layout' ? [] : ['WPStarterTheme/Modules/Layout'];
    $styleAbsPath = Utils::requireAssetPath("Modules/{$moduleName}/style.css");
    $scriptAbsPath = Utils::requireAssetPath("Modules/{$moduleName}/script.js");
    if (is_file($styleAbsPath)) {
      wp_enqueue_style(
        "WPStarterTheme/Modules/{$moduleName}",
        Utils::requireAssetUrl("Modules/{$moduleName}/style.css"),
        $styleDeps,
        null
      );
    }
    if (is_file($scriptAbsPath)) {
      wp_enqueue_script(
        "WPStarterTheme/Modules/{$moduleName}",
        Utils::requireAssetUrl("Modules/{$moduleName}/script.js"),
        ['jquery'],
        null,
        true
      );
    }
  }, 100);
}, 10, 2);
