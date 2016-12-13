<?php

namespace Flynt\Init;

use Flynt;
use Flynt\Helpers\Module;
use Flynt\Helpers\Acf;
use Flynt\Helpers\CustomPostTypeRegister;
use Flynt\Config;

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
