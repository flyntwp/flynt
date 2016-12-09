# 4. Using DataFilters

<div class="alert">
  <h3>This tutorial covers:</h3>
  <ul>
    <li><strong><a href="#41-adding-a-datafilter">4.1 Adding a DataFilter</a></strong></li>
  </ul>
</div>

## 4.1 Adding a DataFilter
It's not always the case that the data we need in our component comes directly from the backend user input. Data Filters are one of the ways in which we can add and modify data before it is passed to the component. It is mainly intended for use with database or API operations. In this case we will put this to use in our Post Slider by passing the "last updated" date to our gallery.

To begin, add the following line in `config/templates/default.json`, just after the `name`:

```php
{
  "name": "ImageSlider",
  "dataFilter": "Flynt/DataFilters/Categories"
}
```

Now create `lib/DataFilters/Categories.php` and add the code below:

```php
add_filter('Flynt/DataFilters/Categories', function($data) {
  global $post;
  $categories = get_the_category($post->ID);
  $data['primaryCategory'] = $categories[0];

  return $data;
});
```

<p class="source-note">Here we take advantage of the standard Wordpress filter functionality. You can read more about this in the <a href="../add-link">plugin documentation</a>, and on the <a href="https://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters" target="_blank">official Wordpress documentation</a>.</p>

We are accessing our component data before it reaches the view, adding our `primaryCategory` and returning it. Now we can use this new data in our view.

Open `Components/PostSlider/index.twig` and update it to match the code below:

```twig
<div is="flynt-post-slider">
  <div class="slider">
    <h1 class="slider-title">{{ title }}</h1>
    <div class="slider-items">
      {% for image in images %}
        <div class="slider-item">
          <img src="{{ image.url  }}" alt="{{ image.alt }}">
        </div>
      {% endfor %}
    </div>
  </div>
  <div class="slider-meta">
    <p class="slider-category">This post is in the {{ primaryCategory }} category.</p>
  </div>
</div>
```

This is only a basic introduction to the power that such data filters afford. Further techniques are covered in the [Advanced section](../advanced/readme.md) of the Flynt documentation.

<div class="alert alert-steps">
  <h2>Next Steps</h2>

  <p>We'll take our component further and improve on the above, taking advantage of the components <code>functions.php</code> to add even more flexibility.</p>

  <p><a href="modify-data.md" class="btn btn-primary">Go to Section 5</a></p>
</div>
