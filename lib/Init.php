<?php

namespace WPStarterTheme\Init;

use WPStarterTheme\Helpers\Module;
use WPStarterTheme\Helpers\ACFFieldGroupComposer;
use WPStarterTheme\Helpers\CustomPostTypeRegister;
use WPStarterTheme\Config;

// register all custom post types
CustomPostTypeRegister::fromDirectory(Config\CUSTOM_POST_TYPE_PATH);

// initialize ACF field groups
ACFFieldGroupComposer::init();

// register all modules in 'Modules' folder
Module::registerAll();
