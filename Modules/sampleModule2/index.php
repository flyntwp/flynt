<div class='modules sample-module2'>
  <h1>sampleModule2: <?= $data('headline'); ?></h1>
  <?php if(!empty($data('text'))) { ?>
    <p><?= $data('text'); ?></p>
  <?php } ?>
  <?php foreach ($data('posts') as $key => $post) { ?>
    <h2><?= $data($post, 'title'); ?></h2>
    <p><?= $data($post, 'content'); ?></p>
  <?php } ?>
  <h2>Area 51</h2>
  <?= $area('area51'); ?>
  <h2>Param1</h2>
  <p><?= $data('param1'); ?></p>
  <h2>Param2</h2>
  <p><?= $data('param2'); ?></p>
</div>
