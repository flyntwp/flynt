<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Plugin Inactive!</title>
    <?php wp_head(); ?>
  </head>
  <body>
    One or more required Plugins are not activated! Please
    <a href="<?= admin_url('plugins.php') ?>">activate or install the required plugin(s)</a>
    and reload the page.
    <?php wp_footer(); ?>
  </body>
</html>
