<?php

namespace Flynt\TimberDynamicResize;

use Flynt\Utils\Options;
use Flynt\Utils\TimberDynamicResize;

const HTACCESS_MARKER = 'Flynt Dynamic Resize';
const HTACCESS_STATE_OPTION = 'flynt_timber_dynamic_resize_htaccess_state';

add_action('acf/init', function (): void {
    global $timberDynamicResize;
    $timberDynamicResize = new TimberDynamicResize();

    $enabled = (bool) get_field('field_global_TimberDynamicResize_dynamicImageGeneration', 'option');
    syncHtaccessRules($enabled);
});

Options::addGlobal('TimberDynamicResize', [
    [
        'label' => __('Dynamic Image Generation', 'flynt'),
        'instructions' => __('Generate images on-the-fly, when requested, not during initial render.', 'flynt'),
        'name' => 'dynamicImageGeneration',
        'type' => 'true_false',
        'default_value' => 0,
        'ui' => true,
    ],
]);

add_action('update_option_options_global_TimberDynamicResize_dynamicImageGeneration', function ($oldValue, $value): void {
    syncHtaccessRules($value === '1', true);
}, 10, 2);

/**
 * Keep the Flynt dynamic resize rewrite marker in sync with the feature setting.
 *
 * @param boolean $enabled Whether dynamic image generation is enabled.
 * @param boolean $force Whether to write the marker regardless of the stored state.
 */
function syncHtaccessRules(bool $enabled, bool $force = false): void
{
    $state = $enabled ? 'enabled' : 'disabled';
    if (!$force && get_option(HTACCESS_STATE_OPTION) === $state) {
        return;
    }

    require_once ABSPATH . 'wp-admin/includes/misc.php';

    $uploads = wp_upload_dir();
    $htaccessFile = trailingslashit($uploads['basedir']) . '.htaccess';
    $restRoute = '/' . trim(TimberDynamicResize::REST_NAMESPACE . TimberDynamicResize::REST_ROUTE, '/');
    $rules = [];

    if ($enabled) {
        $rules = [
            '<IfModule mod_rewrite.c>',
            '  RewriteEngine On',
            '  RewriteCond %{REQUEST_FILENAME} !-f',
            '  RewriteCond %{REQUEST_FILENAME} !-d',
            '  RewriteCond %{QUERY_STRING} (^|&)' . TimberDynamicResize::TOKEN_QUERY_VAR . '=[a-f0-9]{16}(&|$) [NC]',
            '  RewriteRule ^resized/(.+)$ /index.php?rest_route=' . $restRoute . '&path=$1 [B,QSA,L]',
            '</IfModule>',
        ];
    }

    if (!is_dir(dirname($htaccessFile)) && !wp_mkdir_p(dirname($htaccessFile))) {
        error_log(sprintf('TimberDynamicResize: Could not create uploads directory: %s', dirname($htaccessFile)));
        return;
    }

    if (insert_with_markers($htaccessFile, HTACCESS_MARKER, $rules)) {
        update_option(HTACCESS_STATE_OPTION, $state, false);
    }
}

// WPML rewrite fix.
add_filter('mod_rewrite_rules', function (string $rules): string {
    $homeRoot = parse_url(home_url());
    $homeRoot = isset($homeRoot['path']) ? trailingslashit($homeRoot['path']) : '/';

    $wpmlRoot = parse_url(get_option('home'));
    $wpmlRoot = isset($wpmlRoot['path']) ? trailingslashit($wpmlRoot['path']) : '/';

    return str_replace(
        ["RewriteBase {$homeRoot}", "RewriteRule . {$homeRoot}"],
        ["RewriteBase {$wpmlRoot}", "RewriteRule . {$wpmlRoot}"],
        $rules
    );
});
