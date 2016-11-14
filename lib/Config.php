<?php

namespace WPStarterTheme\Config;

define(__NAMESPACE__ . '\TEMPLATE_PATH', get_template_directory());
define(__NAMESPACE__ . '\MODULE_PATH_RELATIVE', '/Modules/');
define(__NAMESPACE__ . '\MODULE_PATH', TEMPLATE_PATH . MODULE_PATH_RELATIVE);
define(__NAMESPACE__ . '\CONFIG_PATH_RELATIVE', '/config/');
define(__NAMESPACE__ . '\CONFIG_PATH', TEMPLATE_PATH . CONFIG_PATH_RELATIVE);
