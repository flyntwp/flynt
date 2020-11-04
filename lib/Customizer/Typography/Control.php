<?php

namespace Flynt\Customizer\Typography;

use Flynt\Utils\Asset;

class Control extends \WP_Customize_Control
{
    public $type = 'flynt-typography';
    public $unit = '';

    public function getFonts()
    {
        $gfonts = Asset::getContents('../lib/Customizer/Typography/webfonts.json');
        $gfonts = json_decode($gfonts, 1);
        $fonts = [];

        foreach ($gfonts['items'] as $font) {
            $key = sanitize_title($font['family']);
            $font['variants'] = array_map('self::parseVariants', $font['variants']);
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

    /**
	 * Refresh the parameters passed to the JavaScript via JSON.
     *
	 * @return array Array of parameters passed to the JavaScript.
	 */
    public function json() {
        $json = parent::json();
        $value = $this->value();
        $fonts = $this->getFonts();
        // print_r($fonts);
        $key = sanitize_title($value['family']);
        $json['id'] = $this->id;
        $json['link'] = $this->get_link();
        $json['value'] = $value;
        $json['font'] = sanitize_title($value['family'] ?? '');
        $json['default'] = $this->default ?? $this->setting->default;
        $json['defaultKey'] = sanitize_title($json['default']['family']);
        $json['fonts'] = $fonts;
        $json['variants'] = $fonts[$key]['variants'];
        $json['subsets'] = $fonts[$key]['subsets'];
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
                <div class="flynt-typography-option">
                    <select
                        class="flynt-typography-select"
                        placeholder="<?php esc_html_e('Select Font', 'flynt'); ?>"
                        value="{{{ data.font }}}"
                    ></select>
                </div>
                <div class="flynt-typography-option">
                    <span class="customize-control-title"><?php esc_html_e('Variants', 'flynt'); ?></span>
                    <div class="flynt-typography-variants">
                        <# _.each(data.variants, function(variant) { #>
                            <label>
                                <input
                                    type="checkbox"
                                    value="{{{ variant }}}"
                                    name="{{{ data.id }}}-{{{ variant }}}"
                                    <# if (_.contains(data.value.variants, variant)) { #>checked='checked'<# } #>
                                >
                                <span>{{{ variant }}}</span>
                            </label>
                        <# }); #>
                    </div>
                </div>
                <div class="flynt-typography-option">
                <span class="customize-control-title"><?php esc_html_e('Subsets', 'flynt'); ?></span>
                    <div class="flynt-typography-subsets">
                        <# _.each(data.subsets, function(subset) { #>
                            <label>
                                <input
                                    type="checkbox"
                                    value="{{{ subset }}}"
                                    name="{{{ data.id }}}-{{{ subset }}}"
                                    <# if (_.contains(data.value.subsets, subset)) { #>checked='checked'<# } #>
                                >
                                <span>{{{ subset }}}</span>
                            </label>
                        <# }); #>
                    </div>
                </div>
                <button type="button" class="flynt-typography-reset button button-secondary" data-key="{{{ data.defaultKey }}}"><?php esc_html_e('Default', 'flynt'); ?></button>
            </div>
        </div>

        <?php
    }
}
