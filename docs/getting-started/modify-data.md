# 5. Modifying Component Data

<div class="alert">
  <h3>This tutorial covers:</h3>
  <ul>
    <li><strong><a href="#51-using-modifycomponentdata-and-functionsphp">Using <code>modifyComponentData</code> and <code>functions.php</code></strong></a></li>
  </ul>
</div>

## 5.1 Using `modifyComponentData` and `functions.php`

Our component is now functional, but looking at our existing view template, we are still left with hard-coded text:

```twig
<div is="flynt-post-slider">
  <!-- ... code ... -->
  <div class="slider-meta">
    <p class="slider-showing">Showing {{ postsPerPage }} posts.</p>
  </div>
</div>
```

The ideal would be to make this text dynamic, but still let the editor insert the `postsPerPage` number where appropriate. Lets implement this!

First, lets create a new field for the Post Slider component named `postsPerPageText`.

Update `Components/PostSlider/fields.json` to match the below:

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
      "name": "posts",
      "label": "Posts",
      "type": "post_object",
      "post_type": ["post"],
      "return_format": "object",
      "multiple": 1,
      "required": 1
    },
    {
      "name": "postsPerPageText",
      "label": "Posts Per Page Text",
      "type": "text",
      "required": 1
    },
  ]
}
```

To combine our text with the date, we will now need to make use of the `modifyComponentData` filter.

**This is the last entry point where it is possible to modify the data of a particular component.**

Since it is component specific, we place this filter into the `functions.php` file of a component.

<p class="source-note source-note--info">This file follows the original Wordpress <code>functions.php</code> functionality, only re-organised to match Flynt's modular structure. <a href="https://codex.wordpress.org/Functions_File_Explained" target="_blank">Read more here</a></p>

Open the backend interface for your page and add the following content to the "Posts Per Page Text" field and hit update:

**"Showing $postsPerPage posts."**

Now we'll take the value and replace the `$postsPerPage` string with the `postsPerPage` data we passed through our data filter.

First create `Components/PostSlider/functions.php` and add the below:

```php
  <?php
  namespace Flynt\Components\PostSlider;

  add_filter('Flynt/modifyComponentData?name=PostSlider', function ($data) {
    $data['postsPerPageText'] = str_replace('$postsPerPage', $data['postsPerPage'], $data['postsPerPageText'])
    return $data;
  }, 10, 2);
```

It is important to note here that it is necessary to append `?name=` to the filter, passing the target component name as a parameter to our `modifyComponentData` filter.

To finish up, update the view template `Components/PostSlider/index.twig` with the below:

```twig
<div is="flynt-post-slider">
  <div class="slider">
    <h1 class="slider-title">{{ title }}</h1>
    <div class="slider-items">
      {% for post in posts %}
        <div class="slider-item">
          <h2>{{ post.title }}</h2>
          <img src="{{ post.thumbnail.src  }}" alt="{{ post.title }}">
        </div>
      {% endfor %}
    </div>
  </div>
  <div class="slider-meta">
    <p class="slider-showing">{{ postsPerPageText }}</p>
  </div>
</div>
```

We're done! Our editor can now change and re-word the text as they wish, adding in the "posts per page" data wherever they need without "hard-coding" it.

<div class="alert alert-steps">
  <h2>Next Steps</h2>

  <p>We have covered the core concepts of building a dynamic content driven component. What's missing is front-end flare. To round up the series we'll dive into assets and how we require styles, scripts, and images.</p>

  <p><a href="component-assets.md" class="btn btn-primary">Go to Section 6</a></p>
</div>
