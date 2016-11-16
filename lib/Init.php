<?php

namespace WPStarterTheme\Init;

use WPStarterTheme\Helpers\Utils;
use WPStarterTheme\Helpers\ACFFieldGroupComposer;

// initialize ACF field groups
ACFFieldGroupComposer::init();

// register all modules in 'Modules' folder
Utils::registerAllModules();
