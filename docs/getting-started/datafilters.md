# 4. Using DataFilters

<div class="alert">
  <h3>This tutorial covers:</h3>
  <ul>
    <li><strong><a href="#41-adding-a-datafilter">4.1 Adding a DataFilter</a></strong></li>
  </ul>
</div>

## 4.1 Adding a DataFilter
It's not always the case that the data we need in our component comes directly from the backend user input.

Data Filters are one of the ways in which we can add and modify data before it is passed to the component. **It is mainly intended for use with database or API operations.**

In this case we will put this to use in our Post Slider by passing the "posts per page" Wordpress reading setting to our view.

To begin, add the following line in `config/templates/default.json`, just after the `name`:

```php
{
  "name": "ImageSlider",
  "dataFilter": "Flynt/DataFilters/Reading"
}
```

Now create `lib/DataFilters/Reading.php` and add the code below:

```php
add_filter('Flynt/DataFilters/Reading', function($data) {
  $data['postsPerPage'] = get_option('posts_per_page');

  return $data;
});
```

<p class="source-note">Here we take advantage of the standard Wordpress filter functionality. You can read more about this in the <a href="../add-link">plugin documentation</a>, and on the <a href="https://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters" target="_blank">official Wordpress documentation</a>.</p>

To make the data set in this Data Filter available in our component, open `config/templates/default.json` and set the DataFilter to the `PostSlider` component:

```json
{
  "name": "MainLayout",
  "dataFilter": "Flynt/DataFilters/WpBase",
  "areas": {
    ...
    "mainTemplate": [
      {
        "name": "Template",
        "dataFilter": "Flynt/DataFilters/MainQuery/Single",
        "areas": {
          "pageComponents": [
            {
              "name": "PostSlider",
              "dataFilter": "Flynt/DataFilters/Reading"
            }
          ]
        }
      }
    ]
  }
}
```

The data returned from our `Reading` DataFilter will now be combined with the data already in the component, making it instantly accessible in our view.

To finish up, open `Components/PostSlider/index.twig` and update it to match the code below:

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
    <p class="slider-showing">Showing {{ postsPerPage }} posts.</p>
  </div>
</div>
```

This is only a basic introduction to the power that such data filters afford. Further techniques are covered in the [Advanced section](../advanced/readme.md) of the Flynt documentation.

<div class="alert alert-steps">
  <h2>Next Steps</h2>

  <p>We'll take our component further and improve on the above, taking advantage of the components <code>functions.php</code> to add even more flexibility.</p>

  <p><a href="modify-data.md" class="btn btn-primary">Go to Section 5</a></p>
</div>
