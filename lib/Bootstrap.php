<?php

namespace Flynt;

class Bootstrap
{
    public static function setTemplateDirectory()
    {
        add_action('after_switch_theme', function () {
            $stylesheet = get_option('stylesheet');

            if (basename($stylesheet) !== 'templates') {
                update_option('stylesheet', $stylesheet . '/templates');
            }
        });

        add_filter('stylesheet', function ($stylesheet) {
            return dirname($stylesheet);
        });
    }

    public static function checkPlugin()
    {
        $pluginActive = class_exists('\\Flynt\\Render');

        if (!$pluginActive) {
            add_action('admin_notices', function () {
                echo '<div class="error"><p>Flynt Core Plugin not activated. Make sure you activate the plugin in <a href="'
                    . esc_url(admin_url('plugins.php#flynt')) . '">'
                    . esc_url(admin_url('plugins.php')) . '</a></p></div>';
            });

            add_filter('template_include', function () {
                $newTemplate = locate_template(['plugin-inactive.php']);
                if ('' != $newTemplate) {
                    return $newTemplate;
                } else {
                    return 'Flynt Core Plugin not activated! Please <a href="'
                        . esc_url(admin_url('plugins.php'))
                        . '">activate the plugin</a> and reload the page.';
                }
            });
        }

        return $pluginActive;
    }
}
