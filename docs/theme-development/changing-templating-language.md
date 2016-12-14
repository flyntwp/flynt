# Changing Templating Language

Whilst the theme uses [Twig](twig.sensiolabs.org) as the default template language, this is not strictly enforced.

## PHP Templates
To use plain PHP, simply create `index.php`, rather than `index.twig`.

The data passed to a component is still available using the `$data` function. For example:

### Twig:
```twig
<div is="flynt-example-module">
  <h1>{{ title }}</h1>
</div>
```

### PHP:
```php
<div is="flynt-example-module">
  <h1><?= $data('title') ?></h1>
</div>
```

## Other Template Engines
To switch to another template engine, use the `renderComponent` filter provided by the Flynt Core plugin.

As an example, the below code demonstrates how to switch to [Smarty](http://www.smarty.net/) for rendering your templates.

```php
<?php
add_filter('Flynt/renderComponent', function($output, $componentName, $componentData, $areaHtml) {
  // Get index file.
  $componentManager = Flynt\ComponentManager::getInstance();
  $filePath = $componentManager->getComponentFilePath($componentName, 'index.tpl');

  // Add areas to data.
  $data = array_merge($componentData, ['areas' => $areaHtml]);

  // Assign data.
  $smarty = new Smarty;
  $smarty->assign($data);

  // Return html rendered by Smarty.
  return $smarty->display($filePath);
}, 10, 4);
```

Your component data will now be available as usual in `index.tpl`:

```smarty
<div is="flynt-example-module">
  <h1>{$title}</h1>
</div>
```
