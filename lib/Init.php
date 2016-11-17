<?php

namespace WPStarterTheme\Init;

use WPStarterTheme\Helpers\Utils;
use WPStarterTheme\Helpers\CustomPostTypeLoader;
use WPStarterTheme\Helpers\ACFFieldGroupComposer;

// register all custom post types
CustomPostTypeLoader::registerCustomPostTypes();

// initialize ACF field groups
ACFFieldGroupComposer::init();

// register all modules in 'Modules' folder
Utils::registerAllModules();
