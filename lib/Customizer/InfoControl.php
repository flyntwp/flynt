<?php

namespace Flynt\Customizer;

use WP_Customize_Control;

class InfoControl extends WP_Customize_Control
{
    public $type = 'info';
    public function render_content() // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    {
        ?>
         <?php if ($this->label) : ?>
            <h2 style="margin: 0 0 10px;" class="panel-title"><?php echo $this->label; ?></h2>
         <?php endif ?>
        <?php if ($this->description) : ?>
            <p style="margin: 0"><?php echo $this->description; ?></p>
        <?php endif ?>
        <?php
    }
}
