<?php

namespace Flynt\Customizer\Control;

class Typography extends \WP_Customize_Control
{
    public $type = 'flynt-typography';
    public $unit = '';

    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     */
    public function to_json() // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    {
        parent::to_json();
        $this->json['id'] = $this->id;
        $this->json['link'] = $this->get_link();
        $this->json['value'] = $this->value();
        $this->json['unit'] = $this->unit;
        $this->json['input_attrs'] = $this->input_attrs;
        $this->json['default'] = $this->default ?? $this->setting->default;
    }

    public function get_fonts()
    {
        $fonts = Asset::getContents('../Components/FeatureGoogleFonts/fonts.json');
        $fonts = json_decode($fonts);

        return array_values(array_filter($fonts->familyMetadataList, function ($font) {
            return $font->axes ? true : false;
        }));
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
        <# if ( data.label ) { #><label for="{{{ data.id }}}" class="customize-control-title">{{{ data.label }}} ({{{ data.unit }}})</label><# } #>
        <# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>

        <div class="customize-control-notifications-container"></div>

        <div class="customize-control-content">
            <div class="flynt-Typography-field">
                <input
                    type="Typography"
                    data-change="number"
                    value="{{{ data.value }}}"
                    {{{ data.link }}}
                    <# _.each(_.extend({'class': 'flynt-Typography flynt-Typography-slider'}, data.input_attrs), function(value, key) { #>
                        {{{ key }}}="{{ value }}"
                    <# }); #>
                >
                <input
                    type="number"
                    data-change="slider"
                    value="{{{ data.value }}}"
                    id="{{{ data.id }}}"
                    {{{ data.link }}}
                    <# _.each(_.extend({'class': 'flynt-Typography flynt-Typography-number'}, data.input_attrs), function(value, key) { #>
                        {{{ key }}}="{{ value }}"
                    <# }); #>
                >
                <button type="button" class="flynt-Typography-reset button button-secondary" data-default="{{{ data.default }}}"><?php esc_html_e('Default', 'flynt'); ?></button>
            </div>
        </div>

        <?php
    }
}
