<?php

use Flynt\BuildConstructionPlan;
use Flynt\Render;

$config = json_decode(file_get_contents(__DIR__ . '/template.json'), true);
$cp = BuildConstructionPlan::fromConfig($config);

echo Render::fromConstructionPlan($cp);
