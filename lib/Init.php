<?php

namespace WPStarterTheme\Init;

use WPStarterTheme\Helpers\Module;
use WPStarterTheme\Helpers\Acf;
use WPStarterTheme\Helpers\CustomPostTypeRegister;
use WPStarterTheme\Config;

// register all custom post types
CustomPostTypeRegister::fromDirectory(Config\CUSTOM_POST_TYPE_PATH);

// initialize ACF Field Groups and Option Pages
Acf\Loader::init([
  'FieldGroupComposer',
  'OptionPages'
]);

// register all modules in 'Modules' folder
Module::registerAll();
