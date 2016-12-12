<?php

namespace Flynt\Theme\Init;

use Flynt;
use Flynt\Theme\Helpers\Module;
use Flynt\Theme\Helpers\Acf;
use Flynt\Theme\Helpers\CustomPostTypeRegister;
use Flynt\Theme\Config;

// initialize plugin defaults
Flynt\initDefaults();

// register all custom post types
CustomPostTypeRegister::fromDirectory(Config\CUSTOM_POST_TYPE_PATH);

// initialize ACF Field Groups and Option Pages
Acf\Loader::init([
  'FieldGroupComposer',
  'OptionPages'
]);

// register all modules in 'Modules' folder
Module::registerAll();
