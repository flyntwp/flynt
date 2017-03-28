<?php
namespace Flynt\Features\Acf;

require_once __DIR__ . '/FieldGroupComposer.php';
require_once __DIR__ . '/OptionPages.php';
require_once __DIR__ . '/Loader.php';
require_once __DIR__ . '/FlexibleContentToggle.php';
require_once __DIR__ . '/GoogleMaps.php';
use Flynt\Features\Acf\Loader;
use Flynt\Utils\Feature;

Loader::setup(Feature::getOption('flynt-acf', 0));
add_action('Flynt/afterRegisterFeatures', 'Flynt\Features\Acf\Loader::init');
add_action('Flynt/afterRegisterFeatures', 'Flynt\Features\Acf\FlexibleContentToggle::init');
add_action('Flynt/afterRegisterFeatures', 'Flynt\Features\Acf\GoogleMaps::init');
