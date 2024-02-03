<?php

namespace Flynt;

use Flynt\Api;
use Flynt\Defaults;
use Flynt\Utils\Options;
use Timber;

/**
 * Responsible for initializing the theme.
 */
class Init
{
    /**
     * Initialize the theme.
     */
    public static function initTheme(): void
    {
        Defaults::init();
        Options::init();
        Timber\Timber::init();

        // Fronted related actions.
        if (!is_admin()) {
            Api::registerHooks();
        }
    }

    /**
     * Load components.
     */
    public static function loadComponents(): void
    {
        $basePath = get_template_directory() . '/Components';
        Api::registerComponentsFromPath($basePath);
        do_action('Flynt/afterRegisterComponents');
    }

    /**
     * Check if required plugins are active.
     *
     * @return boolean True if all required plugins are active.
     */
    public static function checkRequiredPlugins(): bool
    {
        $acfActive = class_exists('acf');

        if (!$acfActive) {
            self::notifyAcfPluginIsMissing();

            add_filter('template_include', function (): void {
                $title = esc_html__('One or more required plugins are not activated!', 'flynt');
                $message = sprintf(
                    // phpcs:ignore Squiz.Commenting.InlineComment.NotCapital
                    // translators: %1$s, %2$s: link wrapper.
                    esc_html__('Please %1$sactivate or install the required plugin(s)%2$s and reload the page.', 'flynt'),
                    '<a href="' . esc_url(admin_url('plugins.php')) . '" target="_blank">',
                    '</a>'
                );
                wp_die(sprintf('<p><strong>%1$s</strong></p><p>%2$s</p>', $title, $message));
            });
        }

        return $acfActive;
    }

    /**
     * Notify the user that the ACF plugin is missing.
     *
     * @return void
     */
    protected static function notifyAcfPluginIsMissing()
    {
        add_action('admin_notices', function (): void {
            $class = esc_attr('notice notice-error');
            $title = esc_html(__('Flynt is missing a required plugin', 'flynt'));
            $pluginName = sprintf(
                // phpcs:ignore Squiz.Commenting.InlineComment.NotCapital
                // translators: %1$s, %2$s: link wrapper.
                esc_html__('%1$sAdvanced Custom Fields PRO%2$s', 'flynt'),
                '<a href="' . esc_url(admin_url('plugins.php')) . '" target="_blank">',
                '</a>'
            );
            $pluginsUrl = sprintf(
                // phpcs:ignore Squiz.Commenting.InlineComment.NotCapital
                // translators: %1$s, %2$s: link wrapper.
                esc_html__('%1$splugin page%2$s', 'flynt'),
                '<a href="' . esc_url(admin_url('plugins.php')) . '" target="_blank">',
                '</a>'
            );

            $message = sprintf(
                // phpcs:ignore Squiz.Commenting.InlineComment.NotCapital
                // translators: %1$s: Plugin Name, %2$s: plugin page.
                esc_html__('%1$s plugin not activated. Make sure you activate the plugin on the %2$s.', 'flynt'),
                $pluginName,
                $pluginsUrl
            );

            printf('<div class="%1$s"><p><strong>%2$s</strong></p><p>%3$s</p></div>', $class, $title, $message);
        });
    }
}
