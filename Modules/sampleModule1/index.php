<div class='modules sample-module1'>
  <h1>sampleModule1: <?= $data('headline'); ?></h1>
  <?php if(!empty($data('text'))) { ?>
    <p><?= $data('text'); ?></p>
  <?php } ?>
</div>
