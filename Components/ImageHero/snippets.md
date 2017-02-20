# Snippets

## Fixed Height Image

`functions.php`

```php
add_action('wp_enqueue_scripts', function () {
  Component::enqueueAssets('ImageHero', [
    [
      'name' => 'objectfit-polyfill',
      'path' => 'vendor/objectfit-polyfill.js',
      'type' => 'script'
    ]
  ]);
});
```

`index.twig`

```html
<div is="flynt-image-hero">
  <div class="imageHero">
    <div class="imageHero-imageWrapper">
      <img class="imageHero-imageElement" srcset src sizes alt>
    </div>
  </div>
</div>
```

`script.js`

```javascript
import 'file-loader?name=vendor/objectfit-polyfill.js!objectFitPolyfill'
```

`style.styl`

```stylus
.imageHero
  &-imageWrapper
    display: block
    height: 500px
    width: 100%

    +below('s')
      height: 250px

  &-imageElement
    display: block
    height: 100%
    object-fit: cover
    width: 100%
```
