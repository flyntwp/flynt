# 3. Using DataFilters

This tutorial covers:
- [3.1 Adding a DataFilter](#31-adding-a-datafilter)
- [3.2 Modifying Data in `functions.php`](#32-modifying-data-in-functionsphp)

## 3.1 Adding a DataFilter
It's not always the case that the data we need in our module comes directly from the backend user input. Data Filters are one of the ways in which we can add and modify data before it is passed to the module. It is mainly intended for use with database or API operations. In this case we will put this to use in our Image Slider by passing the "last updated" date to our gallery.

To begin, add the following line in `config/templates/default.json`, just after the `name`:

```php
{
  "name": "ImageSlider",
  "dataFilter": "Flynt/DataFilters/Gallery"
}
```

Then create the file `lib/DataFilters/Gallery.php` and add the code below:

```php
add_filter('Flynt/DataFilters/Gallery', function($data) {
  global $post;
  $post = get_post($post->ID);
  $data['lastEditedDate'] = $post->post_modified;

  return $data;
});
```

Here we take advantage of the standard Wordpress filter functionality. You can read more about this in the [plugin documentation](/add-link), and on the [official Wordpress documentation]((https://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters)).

Essentially, we are accessing our module data before it reaches the view, adding our `lastEditedDate` and returning it. Now we can use this new data in our view.

Open `Modules/ImageSlider/index.php.pug` and update it to match the code below:

```jade
div(is='flynt-image-slider')
  .slider
    h1.slider-title= $data('title')
    .slider-items
      for image in $data('images')
        .slider-item
          img(src=$data(image, 'url'))
    .slider-meta
      p This gallery was last edited on: #{$data('lastEditedDate')}
```

This is only a basic introduction to the power that such data filters afford. Further techniques are covered in the [Advanced section](/add-link) of the Flynt documentation:

* [Adding Custom Data](/add-link)
* [Adding Arguments to Data Filters](/add-link)


## 3.2 Modifying Data with `functions.php` and `modifyModuleData`

This is great, but looking at our above view template, we are still left with hard-coded text:

```jade
div(is='flynt-image-slider')
  ...
  .slider-meta
    p This gallery was last edited on: #{$data('lastEditedDate')}
```

The ideal would be to make this text dynamic, but still let the editor insert the `lastEditedDate` where appropriate.

As a first step, repeating the steps explained in [section 2](), create a new field for the ImageSlider module named "lastEditedText":

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

Next we will take advantage of the `modifyModuleData` filter. This is the last entry point where you can modify the data of a particular module. Since it is module specific, we place this filter into the `functions.php` file in the module.

To get started, create `Modules/ImageSlider/functions.php`.

This file follows the original Wordpress `functions.php` concept, only reorganised to match Flynt's modular structure.

Open `Modules/ImageSlider/functions.php` and add the code below:

```php
  modifyModuleData?name=ImageSlider
  //find + replace
```

- To use it on a specific module you have to also specify the module name:
- explain the code.


```
- flynt-theme
| - Modules
  | - ImageSlider
    | - functions.php
    | - fields.json
    | - index.php.pug
```
