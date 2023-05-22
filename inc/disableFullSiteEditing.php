<?php

/**
 * Disable Full Site Editing
 */

namespace Flynt\DisableFullSiteEditing;

define('DISABLE_FSE', '__return_true');

/**
 * Disable Templates and Template Parts in Block Editor
 */
add_filter('block_editor_settings_all', function ($settings) {
    $settings['supportsTemplateMode'] = false;
    return $settings;
}, 10);
