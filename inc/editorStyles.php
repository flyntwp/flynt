<?php

/**
 * Add css styles to the classic and block editor (Gutenberg).
 *
 * Internally, WordPress uses the function get_block_editor_theme_styles() to add styles to the block editor.
 * This might fail in local environments due to SSL verification. To avoid this issue, we disable SSL verification
 * for this URL.
 * @see https://developer.wordpress.org/reference/functions/get_block_editor_theme_styles/
 *
 * Hot Module Replacement, ie. reloading CSS without a browser refresh will not work for editor styles.
 */

namespace Flynt\EditorStyles;

use Flynt\Utils\Asset;

add_action('after_setup_theme', function (): void {
    add_theme_support('editor-styles');

    $stylesheet = getEditorStylesheetUrl();
    add_editor_style($stylesheet);
});

function getEditorStylesheetUrl(): string
{
    return str_replace(get_template_directory_uri(), '', Asset::requireUrl('assets/editor-style.scss'));
}

if (Asset::isHotModuleReplacement()) {
    add_filter('http_request_args', function (array $parsedArgs, string $url): array {
        if (getEditorStylesheetUrl() === $url) {
            $parsedArgs['sslverify'] = false;
            $parsedArgs['headers'] = [
                'Accept' => 'text/css'
            ];
        }

        return $parsedArgs;
    }, 10, 2);
}
