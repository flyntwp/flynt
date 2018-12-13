<?php
namespace Flynt;

use Flynt\Defaults;
use Flynt\BuildConstructionPlan;
use Flynt\Render;
use Flynt\ComponentManager;

function initDefaults()
{
    Defaults::init();
}

function registerComponent($componentName, $componentPath = null)
{
    $componentManager = ComponentManager::getInstance();
    $componentManager->registerComponent($componentName, $componentPath);
}

function registerComponentsFromPath($componentBasePath)
{
    foreach (glob("{$componentBasePath}/*", GLOB_ONLYDIR) as $componentPath) {
        $componentName = basename($componentPath);
        registerComponent($componentName, $componentPath);
    }
}
