<?php

namespace WPStarterTheme\Init;

define(__NAMESPACE__ . '\NS', __NAMESPACE__ . '\\');

use WPStarter;

// register your modules
// TODO add registerAll functionality
WPStarter\registerModule('Layout');
WPStarter\registerModule('Template');
WPStarter\registerModule('FooterNavigation');
WPStarter\registerModule('MainNavigation');
WPStarter\registerModule('PageHeader');
WPStarter\registerModule('PostTeasers');
WPStarter\registerModule('PostList');
WPStarter\registerModule('Wysiwyg');
