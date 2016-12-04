# 4. Modifying Data with `functions.php` and `modifyModuleData`

Our module is now functional, but looking at our existing view template, we are still left with hard-coded text:

```jade
div(is='flynt-image-slider')
  ...
  .slider-meta
    p.slider-date This gallery was last edited on: #{$data('lastEditedDate')}
```

The ideal would be to make this text dynamic, but still let the editor insert the `lastEditedDate` where appropriate.

As a first step, repeating the steps explained in [Section Two](dynamic-module.md), create a new field for the ImageSlider module named "lastEditedText":

```json
{
  "fields": [
    {
      "name": "title",
      "label": "Title",
      "type": "text",
      "required": 1
    },
    {
      "name": "images",
      "label": "Images",
      "type": "gallery",
      "mime_types": "jpg, jpeg",
      "required": 1
    },
    {
      "name": "lastEditedText",
      "label": "Last Edited Text",
      "type": "text",
      "required": 1
    },
  ]
}
```

To combine our text with the date, we will now need to make use of the `modifyModuleData` filter. This is the last entry point where it is possible to modify the data of a particular module. Since it is module specific, we place this filter into the `functions.php` file of a module. This file follows the [original Wordpress `functions.php` concept](https://codex.wordpress.org/Functions_File_Explained), only reorganised to match Flynt's modular structure.

Returning to our task - open the backend interface for your page and add the following content to the "Last Edited Text" field: "This gallery was lasted edited on: $date" and hit update. Now we'll take our last edited text and replace the "$date" string with the `lastEditedDate` data we passed through our data filter.

First create `Modules/ImageSlider/functions.php`.

Then, open `Modules/ImageSlider/functions.php` and add the code below:

```php
  <?php
  namespace WPStarterTheme\Modules\ImageSlider;

  add_filter('WPStarter/modifyModuleData?name=ImageSlider', function ($data) {
    $data['lastEditedText'] = str_replace('$date', $data['lastEditedDate'], $data['lastEditedText'])
    return $data;
  }, 10, 2);
```

It is important to note here that it is necessary to pass the module name as a parameter to our `modifyModuleData` filter.

To finish up, update the view template `Modules/ImageSlider/index.php.pug` with the below:

```jade
div(is='flynt-image-slider')
  .slider
    h1.slider-title= $data('title')
    .slider-items
      for image in $data('images')
        .slider-item
          img.slider-image(src=$data(image, 'url'))
    .slider-meta
      p.slider-date= $data('lastEditedText')
```

We're done! Our editor can now change and re-word the last edited text as they wish, adding in the last edited date wherever they need.

---

## Next Steps

We have covered the core concepts of building a dynamic content driven module. What's missing is front-end flare. To round up the series we'll dive into assets and how we require styles, scripts, and images.

**[Go to Section Five](module-assets.md)**
