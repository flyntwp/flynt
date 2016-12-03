# 3. Using DataFilters

This tutorial covers:
- [3.1 Adding a DataFilter](#31-adding-a-datafilter)

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

---

## Next Steps

We'll take our module further and improve on the above, taking advantage of the modules `functions.php` to add even more flexibility.

**[Go to Section 4](/modify-data.md)**
