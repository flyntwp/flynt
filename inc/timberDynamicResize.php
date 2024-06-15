<?php

namespace Flynt\TimberDynamicResize;

use Flynt\Utils\Options;
use Flynt\Utils\TimberDynamicResize;

add_action('acf/init', function (): void {
    global $timberDynamicResize;
    $timberDynamicResize = new TimberDynamicResize();
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
    [
        'label' => __('Relative Upload Path', 'flynt'),
        'instructions' => __('If Timber Dynamic Resize cannot resolve the path to images correctly, set the relative upload path manually.', 'flynt'),
        'name' => 'relativeUploadPath',
        'type' => 'text',
        'conditional_logic' => [
            [
                [
                    'fieldPath' => 'dynamicImageGeneration',
                    'operator' => '==',
                    'value' => '1'
                ]
            ]
        ]
    ],
]);

add_filter('acf/load_field/key=field_global_TimberDynamicResize_relativeUploadPath', function (array $field) {
    global $timberDynamicResize;
    $field['placeholder'] = $timberDynamicResize->getRelativeUploadDir(true);
    return $field;
});

add_action('update_option_options_global_TimberDynamicResize_dynamicImageGeneration', function ($oldValue, $value): void {
    global $timberDynamicResize;
    $timberDynamicResize->toggleDynamic($value === '1');
}, 10, 2);

add_action('update_option_options_global_TimberDynamicResize_relativeUploadPath', function ($oldValue, $value): void {
    global $timberDynamicResize;
    $timberDynamicResize->changeRelativeUploadPath($value);
}, 10, 2);

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

// WebP Express rewrite fix if dynamic image generation is enabled.
add_action('update_option_options_global_TimberDynamicResize_dynamicImageGeneration', function ($oldValue, $value): void {
    $isDynamicImageGenerationEnabled = (bool) $value;
    maybeModifyUploadsHtaccess($isDynamicImageGenerationEnabled);
}, 10, 2);

add_action("admin_init", function () {
    $isWebExpressOptionsPage = strpos($_SERVER['REQUEST_URI'], 'webp_express_settings_page') !== false;

    if (!$isWebExpressOptionsPage) {
        return;
    }

    $webpExpressMessagesPending = (bool) get_option('webp-express-messages-pending');
    if ($webpExpressMessagesPending === true) {
        $isDynamicImageGenerationEnabled = (bool) get_field('field_global_TimberDynamicResize_dynamicImageGeneration', 'option');
        maybeModifyUploadsHtaccess($isDynamicImageGenerationEnabled);
    }
});

function maybeModifyUploadsHtaccess(bool $enabledDynamicImageGeneration): void
{
    $uploadsHtaccessFile = WP_CONTENT_DIR . '/uploads/.htaccess';
    $rewriteRules = <<<EOT
      # BEGIN TimberDynamicResize
      RewriteCond %{QUERY_STRING} (^|&)ref= [NC]
      RewriteCond %{HTTP_HOST} ^(.+)$
      RewriteCond %{REQUEST_URI} ^.*/resized/(.+)$
      RewriteCond %{DOCUMENT_ROOT}%{REQUEST_URI} !-f
      RewriteRule ^ https://%{HTTP_HOST}/index.php?resized-images=%1&%{QUERY_STRING} [R=302,L]
      # END TimberDynamicResize
    EOT;

    $fnAddRewriteRulesToHtaccess = function () use ($uploadsHtaccessFile, $rewriteRules): void {
        if (!file_exists($uploadsHtaccessFile)) {
            return;
        }

        $uploadsHtaccessContent = file_get_contents($uploadsHtaccessFile);

        if (strpos($uploadsHtaccessContent, 'RewriteEngine On') === false) {
            return;
        }

        if (
            strpos($uploadsHtaccessContent, '# BEGIN TimberDynamicResize') !== false &&
            strpos($uploadsHtaccessContent, '# END TimberDynamicResize') !== false
        ) {
            return;
        }

        $uploadsHtaccessContent = str_replace(
            'RewriteEngine On',
            "RewriteEngine On\n\n{$rewriteRules}",
            $uploadsHtaccessContent
        );

        file_put_contents($uploadsHtaccessFile, $uploadsHtaccessContent);
    };

    $fnRemoveRewriteRulesFromHtaccess = function () use ($uploadsHtaccessFile): void {
        if (!file_exists($uploadsHtaccessFile)) {
            return;
        }

        $uploadsHtaccessContent = file_get_contents($uploadsHtaccessFile);

        if (
            strpos($uploadsHtaccessContent, '# BEGIN TimberDynamicResize') === false ||
            strpos($uploadsHtaccessContent, '# END TimberDynamicResize') === false
        ) {
            return;
        }

        $uploadsHtaccessContent = preg_replace(
            "/# BEGIN TimberDynamicResize.*?# END TimberDynamicResize\\s*/s",
            '',
            $uploadsHtaccessContent
        );

        file_put_contents($uploadsHtaccessFile, $uploadsHtaccessContent);
    };

    if ($enabledDynamicImageGeneration) {
        $fnAddRewriteRulesToHtaccess();
    } else {
        $fnRemoveRewriteRulesFromHtaccess();
    }
}
