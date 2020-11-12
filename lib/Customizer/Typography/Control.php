<?php

namespace Flynt\Customizer\Typography;

use Flynt\Utils\Asset;

class Control extends \WP_Customize_Control
{
    public $type = 'flynt-typography';
    public $unit = '';

    public function getFonts()
    {
        /**
         * Use this link to get the fonts. You will need to create an API key first.
         * https://webfonts.googleapis.com/v1/webfonts?fields=items(family,variants,subsets,category)&key={yourApiKey}
         */
        $gfonts = Asset::getContents('../lib/Customizer/Typography/webfonts.json');
        $gfonts = json_decode($gfonts, 1);
        $fonts = [];

        foreach ($gfonts['items'] as $font) {
            $key = sanitize_title($font['family']);
            $font['variants'] = array_map('self::parseVariants', $font['variants']);
            $font['variants'] = array_values(array_filter($font['variants'], 'self::removeItalicVariants'));
            $fonts[$key] = array_merge([
                'id' => $key,
                'text' => $font['family'],
            ], $font);
        }

        return $fonts;
    }

    public static function parseVariants($variant)
    {
        $variants = [
            'regular' => '400',
            'italic' => '400italic',
        ];

        return $variants[$variant] ?? $variant;
    }

    public static function removeItalicVariants($variant)
    {
        return strpos($variant, 'italic') === false;
    }

    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     *
     * @return array Array of parameters passed to the JavaScript.
     */
    public function json()
    {
        $json = parent::json();
        $value = $this->value();
        $fonts = $this->getFonts();
        $key = sanitize_title($value['family']);
        $json['id'] = $this->id;
        $json['link'] = $this->get_link();
        $json['value'] = $value;
        $json['font'] = sanitize_title($value['family'] ?? '');
        $json['default'] = $this->default ?? $this->setting->default;
        $json['defaultKey'] = sanitize_title($json['default']['family']);
        $json['fonts'] = $fonts;
        $json['variants'] = array_filter($fonts[$key]['variants'], function ($variant) {
            return strpos($variant, 'italic') === false;
        });
        return $json;
    }

    /**
     * Don't render the control content from PHP, as it's rendered via JS on load.
     */
    public function render_content() // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    {
    }

    /**
     * Render a JS template for control display.
     */
    public function content_template() // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    {
        ?>
        <# if ( data.label ) { #><label for="{{{ data.id }}}" class="customize-control-title">{{{ data.label }}}</label><# } #>
        <# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>

        <div class="customize-control-notifications-container"></div>

        <div class="customize-control-content">
            <div class="flynt-typography-field">
                <div class="flynt-typography-option flynt-typography-option--family">
                    <span class="flynt-typography-option-title"><?php esc_html_e('Family', 'flynt'); ?></span>
                    <select class="flynt-typography-family"></select>
                </div>
                <div class="flynt-typography-option flynt-typography-option--variant">
                    <span class="flynt-typography-option-title"><?php esc_html_e('Weight', 'flynt'); ?></span>
                    <select class="flynt-typography-variant">
                        <# _.each(data.variants, function(variant) { #>
                            <option
                                value="{{{ variant }}}"
                                <# if (_.isEqual(data.value.variant, variant)) { #>selected='selected'<# } #>
                            >{{{ variant }}}</option>
                        <# }); #>
                    </select>
                </div>
            </div>
            <button type="button" class="flynt-typography-reset button button-secondary" data-key="{{{ data.defaultKey }}}"><?php esc_html_e('Default', 'flynt'); ?></button>
        </div>

        <?php
    }
}
