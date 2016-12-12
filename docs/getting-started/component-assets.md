# 6. Adding Assets to a Component

<div class="alert">
  <h3>This tutorial covers:</h3>
  <ul>
    <li><strong><a href="#61-adding-styles">6.1 Adding Styles</a></strong></li>
    <li><strong><a href="#62-adding-scripts">6.2 Adding Scripts</a></strong></li>
    <li><strong><a href="#63-adding-and-registering-dependencies">6.3 Adding and Registering Dependencies</a></strong></li>
    <li><strong><a href="#64-adding-static-assets">6.4 Adding Static Assets</a></strong></li>
  </ul>
</div>

## 6.1 Adding Styles
Each component can have a self-contained style file. By default, Flynt supports vanilla CSS files, and the pre-processor [Stylus](http://stylus-lang.com/). In this tutorial we will use Stylus.

**[If you do not like Stylus or vanilla CSS, you can learn how to switch the styling language here.](../theme-development/switching-styling-language.md)**

To get started, create `Components/PostSlider/style.styl` and add the styles below:

```stylus
[is='flynt-post-slider']
  *,
  *:before,
  *:after
    box-sizing: border-box

  .slider
    center(1200px)

    &-title
      color: #74afad

    &-image
      display: block
      width: 100%

    &-showing
      color: #558c89
```

Before these styles will show up, we need to enqueue our stylesheet.

Open `Components/PostSlider/functions.php` and add the following code below the component namespace:

```php
use Flynt\Helpers\Component;
```

Then, at the bottom, add the code below to enqueue the stylesheet:

```php
add_action('wp_enqueue_scripts', function () {
  Component::enqueueAssets('ImageSlider');
});

```

With `Component::enqueueAssets` we are telling our component to look for any style or script file within the component folder and enqueue it. [You can read more in the Flynt Core plugin documentation](/add-link).

In summary, the `Components/PostSlider/functions.php` file now looks like the following:

```php
  <?php
  namespace Flynt\Components\ImageSlider;

  use Flynt\Helpers\Component;

  add_filter('Flynt/modifyComponentData?name=ImageSlider', function ($data) {
    $data['lastEditedText'] = str_replace('$date', $data['lastEditedDate'], $data['lastEditedText']);
    return $data;
  }, 10, 2);

  add_action('wp_enqueue_scripts', function () {
    Component::enqueueAssets('ImageSlider');
  });
```

Refresh your page and you will now see our new styles.

That's it! Though there are a few more recommendations to keep in mind:

- Each component is uniquely identified with the `is` attribute. We use this for both styling and scripting, as you will see below. All styles are scoped within this one over-arching identifier.
- At the core of the Flynt philosophy is reusability and scalability. As such, we strongly recommend following [maintainableCSS](http://maintainablecss.com/); an approach to writing modular and maintainable styles.

## 6.2 Adding Scripts
Just as with our styles, scripts live at the Component level and are completely self contained.

Create `Components/PostSlider/script.js` and add the following code:

```js
class PostSlider extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.resolveElements()
    return self
  }

  // Scope elements we need to the module
  resolveElements () {
    this.$slider = $('.slider-items', this)
  }

  connectedCallback () {
    console.log('connected')
  }
}

window.customElements.define('flynt-post-slider', PostSlider, {extends: 'div'})
```

This is our basic recommended Javascript Custom Element starting template. It is written in ES2015, and will be compiled to ES5 using [Babel](https://babeljs.io/).

<p class="source-note">Before continuing we strongly recommended reading <a href="https://developers.google.com/web/fundamentals/getting-started/primers/customelements">Google's Getting Started Primer for Custom Elements</a>. However, we will build upon this template in the coming sections.</p>

If you are not comfortable with Custom Elements or ES2015, we do not force you to adopt this for your Javascript (only strongly recommend it). At a basic level, the component `script.js` file will always be copied into the matching `dist` folder. You are free to write the Javascript within it as you wish.

## 6.3 Adding and Registering Dependencies
In order to turn our images into a real slider, we'll use [Yarn](https://yarnpkg.com) to add [Slick Carousel](http://kenwheeler.github.io/slick/) to our component.

In the theme root folder, open your terminal and run this command to install Slick:

```
yarn add slick-carousel -D
```

Now we need to import this dependency into our component.

First, we will let Flynt know which scripts and styles from slick need copying into the `build/vendor` folder.

Do this by adding the below code to the top of `Components/PostSlider/script.js`:

```js
import 'file-loader?name=vendor/slick.js!slick-carousel'
import 'file-loader?name=vendor/slick.css!slick-carousel/slick/slick.css'
```

Now that the files are copied to `dist/vendor` we need to enqueue these assets.

Open `Components/PostSlider/functions.php` and enqueue the dependencies by modifying the `enqueueAssets` function to match the below:

```php
add_action('wp_enqueue_scripts', function () {
  Component::enqueueAssets('ImageSlider', [
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

Great! All that is left is modify the `connectedCallback` function to initialize the plugin.

Open `Components/PostSlider/script.js` and update the contents to match the following:

```js
import 'file-loader?name=vendor/slick.js!slick-carousel'
import 'file-loader?name=vendor/slick.css!slick-carousel/slick/slick.css'

class PostSlider extends window.HTMLDivElement {
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
    this.$slider.slick({
      autoplay: 3000,
      arrows: false,
      dots: true
    })
  }
}

window.customElements.define('flynt-post-slider', PostSlider, {extends: 'div'})
```

## 6.4 Adding Static Assets
Sometimes we need static assets, such as icons, that do not come directly from the user in the back-end.

To implement this, create an `asset` directory in the ImageSlider component directory. Then, download and add `downloadIcon.svg` ([available here](http://iconmonstr.com/download-11/)) to the new `asset` directory.

```
| flynt-theme
|── Components
    └── ImageSlider
       └── Assets/
          └── downloadIcon.svg
```

When gulp is running, any image (JPG, JPEG, PNG, GIF) or SVG file placed into this folder will be automatically copied to the corresponding folder within `dist`.

In our case, `downloadIcon.svg` will be copied to `dist/Components/PostSlider/assets/downloadIcon.svg`.

For caching purposes, all static assets are automatically revisioned by gulp (for example, `downloadIcon.svg` → `downloadIcon-d41d8cd98f.svg`).

As such, to include assets in a component, it is necessary to use the `requireAssetUrl` function. This is a utility function provided by the Flynt Core plugin. You can read more about this in the [Flynt Core plugin documentation](/add-link).

Open `Components/PostSlider/functions.php`. At the top of the file, we need to `use` our `Utils` helpers:

```php
<?php
namespace Flynt\Components\ImageSlider;

use Flynt\Helpers\Utils;
//...
```

We will then add the image URL to our component data by calling the `requireAssetUrl` function with the path to our image:

```php
 add_filter('Flynt/modifyComponentData?name=ImageSlider', function ($data) {
   $data['downloadIconUrl'] = Utils::requireAssetUrl('Components/PostSlider/assets/downloadIcon.svg');
   ...
   return $data;
 }, 10, 2);
```

In summary, the `Components/PostSlider/functions.php` should now match the below code:

```php
<?php
namespace Flynt\Components\ImageSlider;

use Flynt\Helpers\Utils;
use Flynt\Helpers\Component;

add_filter('Flynt/modifyComponentData?name=ImageSlider', function ($data) {
  $data['downloadIconUrl'] = Utils::requireAssetUrl('Components/PostSlider/assets/downloadIcon.svg');
  $data['lastEditedText'] = str_replace('$date', $data['lastEditedDate'], $data['lastEditedText']);
  return $data;
}, 10, 2);

add_action('wp_enqueue_scripts', function () {
  Component::enqueueAssets('ImageSlider', [
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

We now have the icon URL available in our component data. Lets use what we learnt in the previous steps to add this icon to our template, along with some styling for the icon:

In `Components/PostSlider/index.twig`:

```twig
<div is="flynt-post-slider">
  <div class="slider">
    <h1 class="slider-title">{{ title }}</h1>
    <div class="slider-items">
      {% for post in posts %}
        <div class="slider-item">
          <h2>{{ post.title }}</h2>
          <div class="slider-image-wrapper">
            <a class="slider-icon" href="{{ post.thumbnail.src }}" target="_blank">
              <img src="{{ downloadIconUrl }}" alt="Download">
            </a>
            <img src="{{ post.thumbnail.src  }}" alt="{{ post.title }}">
          </div>
        </div>
      {% endfor %}
    </div>
  </div>
  <div class="slider-meta">
    <p class="slider-showing">{{ postsPerPageText }}</p>
  </div>
</div>
```

In `Components/PostSlider/style.styl`:

```stylus
[is='flynt-post-slider']
  .slider
    center(1200px)

    &-title
      color: #74afad

    &-image
      display: block
      width: 100%

    &-showing
      color: #558c89

    &-image-wrapper
      position: relative

    &-icon
      bottom: 20px
      display: block
      height: 30px
      position: absolute
      right: 20px
      width: 30px
```

Refresh the front-end and you will see that we are done!

<div class="alert alert-steps">
  <h2>Next Steps</h2>

  <p>This concludes the "Getting Started" series! In the last step we'll recap what we've achieved and recommend where to go from here.</p>

  <p><a href="recap.md" class="btn btn-primary">Go to Section 7</a></p>
</div>
