<?php

function menuOptions()
{
    $screen = get_current_screen();
    if ($screen->id != 'nav-menus') // phpcs:ignore
        return;
    ?>
    <script type="text/javascript">
        jQuery(function($) {
            $warn = false;

            $el = $('#select-menu-to-edit option:selected');
            $menu = $el.val();
            $editor = $('#menu-to-edit');
            $add = $('.submit-add-to-menu');
            $update = $('#update-nav-menu');
            $current = '.menu-item-depth-0';
            $new = '.menu-item-checkbox:checked';

            if ($menu === '3') {
                wpNavMenu.options.globalMaxDepth = 1;
            };

            $add.on('click', function() {
                var num = $editor.children($current).length;
                num += $($new).length;
                if (num > 4) {
                    if ($warn == true) {
                        alert('Limit is 4 Columns');
                    }
                    return false;
                }
            });

            $update.on('submit', function() {
                var num = $editor.children($current).length;
                if (num > 4) {
                    if ($warn == true) {
                        alert('Limit is 4 Columns');
                    }
                    return false;
                }
            });
        })
    </script>
    <?php
}
add_action('admin_footer', 'menuOptions');
