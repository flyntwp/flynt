# 2. Adding ACF Fields and Manipulating Data

This tutorial covers:
- [Adding ACF Fields](#adding-fields)
- [Adding a Field Group](#adding-a-field-group)
- [Displaying Content with `$data()`](#displaying-content-with-data)
- [Adding a DataFilter](#adding-a-datafilter)
- [Modifying Data in `functions.php`](#modifying-data-in-functionsphp)

**A requirement of this tutorial is using the Wordpress Plugin Advanced Custom Fields (ACF). Please make sure this is installed and enabled before continuing.**

## Adding ACF Fields
To get started, we will add a text field for our title. Create a `ImageSlider/fields.json` file and add the code below to it:

```json
{
  "layout": {
    "name": "ImageSlider",
    "label": "Image Slider",
    "sub_fields": [
      {
        "name": "title",
        "label": "Title",
        "type": "text",
        "required": 1
      }
    ]
  }
}
```

The folder structure will now resemble the following:

```
- flynt-theme
| - Modules
  | - ImageSlider
    | - fields.json
    | - index.php.pug
```

That's it! Navigate to the backend of your Wordpress installation and create a new page. At the bottom, you'll now see a new section for your Image Slider module, with a field inside labeled "Title".

**Add a screenshot here.**

This functionality is driven by the Advanced Custom Fields (ACF) Wordpress plugin, and there are many other field types available. Flynt supports all of the field types provided by ACF, as well as all of the default field options as provided by the plugin. To see the full list of available fields and their available options, check out the [official ACF documentation here](https://www.advancedcustomfields.com/resources/#field-types).

Since we are making an image slider, let's also add a gallery field to our module, again using the `field.json` file:

```json
{
  "layout": {
    "name": "ImageSlider",
    "label": "Image Slider",
    "sub_fields": [
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
    ]
  }
}
```

Again, open up your new page in the backend, and you will now see our new gallery field, with the label "Images". Next, we need some sample content. Add "Our Image Gallery" into the title text field, and then two images into the image gallery. For ease, we have prepared some sample images that you can [download here](#). (Source: [Unsplash](https://unsplash.com).)

Press the "Update" button to save the content to the page. Next, we will move on to displaying this content on the front-end.

<!-- - Extra: Add fields quicker using our acf-field-snippets. For atom + sublime text. Coming soon?! -->

## Adding a Field Group

## Displaying Content with `$data()`


## Adding a DataFilter
In `config/templates/default.json`:
```php
{
  "name": "ImageSlider",
  "dataFilter": "Flynt/DataFilters/ImageSliderFilter"
}
```

In `ImageSlider/functions.php`:
```php
add_filter('Flynt/DataFilters/ImageSliderFilter', function($data) {
  $data['foo'] = 'bar';
  return $data;
});
```

- link to advanced: custom data.
- link to advanced: adding arguments to the data filter?

## Modifying Data in `functions.php`
