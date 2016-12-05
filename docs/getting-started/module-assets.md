# 5. Adding Assets to a Module

This tutorial covers:
- [5.1 Adding Styles](#51-adding-styles)
- [5.2 Adding Scripts](#52-adding-scripts)
- [5.3 Adding and Registering Dependencies](#53-adding-and-registering-dependencies)
- [5.4 Adding Static Assets](#54-adding-static-assets)

## 5.1 Adding Styles
Each module can have a self-contained style file. By default, Flynt supports vanilla CSS files, and Stylus. In this tutorial, we will use Stylus. [You can learn how to switch the styling language here](../theme-development/switching-styling-language.md).

To get started, create `Modules/ImageSlider/style.styl` and add the styles below:

```stylus
[is='flynt-image-slider']
  .slider
    &-title
      color: #74afad

    &-image
      display: block
      width: 100%

    &-date
      color: #558c89
```

Before these styles will show up, we need to first enqueue our stylesheet. Open `ImageSlider/functions.php` and add the following code below the module namespace:

```php
use WPStarterTheme\Helpers\Module;
```

Then, at the bottom of `ImageSlider/functions.php`, add the below code to enqueue the stylesheet:

```php
add_action('wp_enqueue_scripts', function () {
  Module::enqueueAssets('ImageSlider');
});

```

In summary, the `ImageSlider/functions.php` file should now look like the following:

```php
  <?php
  namespace WPStarterTheme\Modules\ImageSlider;

  use WPStarterTheme\Helpers\Module;

  add_filter('WPStarter/modifyModuleData?name=ImageSlider', function ($data) {
    $data['lastEditedText'] = str_replace('$date', $data['lastEditedDate'], $data['lastEditedText']);
    return $data;
  }, 10, 2);

  add_action('wp_enqueue_scripts', function () {
    Module::enqueueAssets('ImageSlider');
  });
```

Refresh your page and you will now see our new styles.

<!-- TODO: Talk about [is=''] syntax for styling  -->
<!-- TODO: Talk about maintainableCSS as a recommendation  -->
<!-- TODO: Talk briefly about enqueueStyles, and link to enqueueStyles explanation in the plugin documentation.  -->

## 5.2 Adding Scripts
Just as with our styles, scripts live at the Module level and are completely self contained. Create the `Modules/ImageSlider/script.js` file and add the following code:

```js
class ImageSlider extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.resolveElements()
    return self
  }

  resolveElements () {
    this.$slider = $('.slider-items', this)
  }

  connectedCallback () {
    console.log('connected')
  }
}

window.customElements.define('flynt-image-slider', SliderCols, {extends: 'div'})
```

This is our basic recommended Javascript Custom Element starting template. Before continuing we strongly recommended reading [Google's Getting Started Primer for Web Components](https://developers.google.com/web/fundamentals/getting-started/primers/customelements). However, we will build upon this template in the coming sections.

## 5.3 Adding and Registering Dependencies
In order to turn our images into a real slider, we'll use Yarn to add [Slick Carousel](https://www.google.de/url?sa=t&rct=j&q=&esrc=s&source=web&cd=1&ved=0ahUKEwiZmZ_T1NjQAhUlAZoKHUEcC04QFgggMAA&url=http%3A%2F%2Fkenwheeler.github.io%2Fslick%2F&usg=AFQjCNGx_jdVLP__MakcyBIdSRV4kKFe2Q&sig2=zh58rnGs2haFdG1tRv7UXA) to our module. In your terminal, in the theme folder, run this command:

```
yarn add slick-carousel -D
```

Now we need to import this dependency into our module. First, we will let Flynt know which scripts and styles from slick need copying into the `build/vendor` folder. Do this by adding the below code to the top of the `Modules/ImageSlider/script.js` file:

```js
import 'file-loader?name=vendor/slick.js!slick-carousel'
import 'file-loader?name=vendor/slick.css!slick-carousel/slick/slick.css'
```

<!-- TODO: Mention the fact that it will look for main dist file if main exists in package. -->

Now that the files are copied to the `dist/vendor` folder, we need to enqueue these assets.

Open `Modules/ImageSlider/functions.php` and enqueue the dependencies by modifying the `enqueueAssets` function to match the below code:

```php
add_action('wp_enqueue_scripts', function () {
  Module::enqueueAssets('ImageSlider', [
    [
      'name' => 'slick-carousel',
      'path' => 'vendor/slick.js',
      'type' => 'script'
    ],
    [
      'name' => 'slick-carousel',
      'path' => 'vendor/slick.css',
      'type' => 'style'
    ]
  ]);
});
```

We have now successfully copied and enqueued Slick. All that is left is to initialise the plugin in our module script. To finish up, open `Modules/ImageSlider/script.js` and replace the contents with the following:

```js
import 'file-loader?name=vendor/slick.js!slick-carousel'
import 'file-loader?name=vendor/slick.css!slick-carousel/slick/slick.css'

class ImageSlider extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.resolveElements()
    return self
  }

  resolveElements () {
    this.$slider = $('.slider-items', this)
  }

  connectedCallback () {
    this.$slider.slick()
  }
}

window.customElements.define('flynt-image-slider', SliderCols, {extends: 'div'})
```

## 5.4 Adding Static Assets
Create an `Asset` directory in the ImageSlider module directory. Then, download and add `example.jpg` ([available here](/add-link)) to the new `Asset` directory.

```
- flynt-theme
| - Modules
  | - ImageSlider
    | - Assets
      | - example.jpg
```

When gulp is running, any image (JPG, JPEG, PNG, GIF) or SVG file placed into this folder will be automatically copied to the corresponding folder within `dist`.

In our case, `example.jpg` will be copied to `dist/Modules/ImageSlider/Assets/example.jpg`.

For caching purposes, all static assets are automatically revisioned by gulp (for example, `example.jpg` → `example-d41d8cd98f.jpg`).

As such, to include assets in a module, it is necessary to use the `requireAssetUrl` function. This is a utility function provided by the Flynt Core plugin. You can read more about this in the [Flynt Core plugin documentation](/add-link).

To use this, open `Modules/ImageSlider/functions.php`.

At the top of the file, we need to `use` our `Utils` helpers:

```php
<?php
namespace WPStarterTheme\Modules\ImageSlider;

use WPStarterTheme\Helpers\Utils;
...
```

Then, we will set the image source by calling the `requireAssetUrl` function with our image file path:
 and then add the asset to our module data within the `modifyModuleData` filter.

```php
 add_filter('WPStarter/modifyModuleData?name=ImageSlider', function ($data) {
   $data['imgSrc'] = Utils::requireAssetUrl('Modules/ImageSlider/Assets/example.jpg');
   ...
   return $data;
 }, 10, 2);
```

In summary, the `Modules/ImageSlider/functions.php` should now match the below code:

```php
<?php
namespace WPStarterTheme\Modules\ImageSlider;

use WPStarterTheme\Helpers\Utils;
use WPStarterTheme\Helpers\Module;

add_filter('WPStarter/modifyModuleData?name=ImageSlider', function ($data) {
  $data['imgSrc'] = Utils::requireAssetUrl('Modules/ImageSlider/Assets/example.jpg');
  $data['lastEditedText'] = str_replace('$date', $data['lastEditedDate'], $data['lastEditedText']);
  return $data;
}, 10, 2);

add_action('wp_enqueue_scripts', function () {
  Module::enqueueAssets('ImageSlider', [
    [
      'name' => 'slick-carousel',
      'path' => 'vendor/slick.js',
      'type' => 'script'
    ],
    [
      'name' => 'slick-carousel',
      'path' => 'vendor/slick.css',
      'type' => 'style'
    ]
  ]);
});
```
