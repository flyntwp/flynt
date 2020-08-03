<?php

namespace Flynt\Customizer;

use WP_Customize_Control;

class SeparatorControl extends WP_Customize_Control
{
    public $type = 'separator';
    public function render_content() // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    {
        ?>
        <p><hr></p>
        <?php
    }
}
