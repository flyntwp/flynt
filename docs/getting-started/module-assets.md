# Adding Assets to a Module; Styles, Scripts, and Images

This tutorial covers:
- Adding styles to a module.
- Adding scripts to your module.
- Adding and register dependencies to your project.
- Adding static images and SVGs.

## Styles
Create a `style.styl` file in the PostList module directory.

```
- flynt-theme
| - Modules
  | - PostList
    | - index.php.pug
    | - functions.php
    | - style.styl
```

Now we need to enqueue our main module stylesheet. Open `PostList/functions.php` and add the following code at line 5, below the Utils `use` declaration:

```php
use WPStarterTheme\Helpers\Module;
```

Now, at the bottom of `PostList/functions.php`, add the below code to enqueue the styles:

```php
add_action('wp_enqueue_scripts', function () {
  Module::enqueueAssets('PostList');
});

```

In summary, the `PostList/functions.php` file should now look like this:

```
final functions.php code needs to go here.
```

Open `PostList/style.styl` and add the following styles.
```stylus
[is='flynt-post-list']
  .post-title
    color: red
```

Refresh your page and admire the beauty of your module.

## Scripts
Create a `script.js` file in the PostList module directory.

```
- flynt-theme
| - Modules
  | - PostList
    | - index.php.pug
    | - functions.php
    | - style.styl
    | - script.js
```

### Script Dependencies
Install and save the dependency using yarn.
```
yarn add slick-carousel --D
```

Now open `PostList/script.js`. We need to import our new vendor files and at the same time copy our script (is it webpack?) to the `dist/vendor` folder. We can do this by adding the following to the top of the file:

```js
import 'file-loader?name=vendor/slick.js!slick-carousel'
import 'file-loader?name=vendor/slick.css!slick-carousel/slick/slick.css'
```
- What about the fact that it will look for main dist file if main exists.

Now that the files are copied to the `dist/vendor` folder, we need to enqueue these assets. Open `PostList/functions.php` and enqueue the dependencies using the below code:

```php
add_action('wp_enqueue_scripts', function () {
  Module::enqueueAssets('PostList', [
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

### Custom Elements...?

## Images/SVGs
Create an `Asset` directory in the PostList module directory. Then, download and add `example.jpg` ([available here](#)) to the new `Asset` directory.

```
- flynt-theme
| - Modules
  | - PostList
    | - Assets
      | - example.jpg
    | - index.php.pug
    | - style.styl
    | - script.js
```
