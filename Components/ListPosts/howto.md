# Developer HowTo´s

## Add tags
`Partials/Tags/index.twig`
```twig
{% if post.tags %}
  <ul class="tags">
    {% for tag in post.tags %}
      <li class="tags-item">
        <a class="tags-link" href="{{ tag.link }}">{{ tag.title }}</a>
      </li>
    {% endfor %}
  </ul>
{% endif %}
```

`Partials/Tags/_style.styl`
```stylus
.tags
  clearfix()
  list-style-type: none
  margin: 0
  padding: 0

  &-item
    float: left
    margin-right: 10px

```

`style.styl`
```stylus
.flyntComponent[is="flynt-list-posts"]
  .listPosts
    @import 'Partials/Tags/_style'
```

`Partials/PostTeaser/index.twig`
```twig
{% include 'Partials/Tags/index.twig' %}
```

## Add categories
`Partials/Categories/index.twig`
```twig
{% if post.categories %}
  <ul class="categories">
    {% for category in post.categories %}
      <li class="categories-item">
        <a class="categories-link" href="{{ category.link }}">{{ category.title }}</a>
      </li>
    {% endfor %}
  </ul>
{% endif %}
```

`Partials/Categories/_style.styl`
```stylus
.categories
  clearfix()
  list-style-type: none
  margin: 0
  padding: 0

  &-item
    float: left
    margin-right: 10px
```

`style.styl`
```stylus
.flyntComponent[is="flynt-list-posts"]
  .listPosts
    @import 'Partials/Categories/_style'
```

`Partials/PostTeaser/index.twig`
```twig
{% include 'Partials/Categories/index.twig' %}
```

## All posts cta partial

`Partials/AllPostsCta/index.twig`
```twig
{% if not isArchive and (allPostsCtaLabel and allPostsCtaLink) %}
  <div class="allPostsCta">
    <a href="{{ allPostsCtaLink }}" class="btn btn-primary">{{ allPostsCtaLabel }}</a>
  </div>
{% endif %}
```

`Partials/AllPostsCta/_style.style`
```stylus
$containerMaxWidth = lookup('$globalContainerMaxWidth') || 1280px
$containerPadding = lookup('$globalContainerPadding') || 20px

.allPostsCta
  center($containerMaxWidth, $containerPadding)
  text-align: center
```

`index.twig`
```twig
<div is="flynt-list-posts" class="flyntComponent">
  <div class="listPosts">
    {% if posts %}
      <ul class="listPosts-list">
        {% for post in posts %}
          {% include 'Partials/PostTeaser/index.twig' %}
        {% endfor %}
      </ul>
      {% include 'Partials/AllPostsCta/index.twig' %}
      {% include 'Partials/PaginationButtons/index.twig' %}
    {% else %}
      <p class="listPosts-noPosts">{{ noPostsFoundText }}</p>
    {% endif %}
  </div>
</div>
```

`style.styl`
```stylus
.flyntComponent[is="flynt-list-posts"]
  .listPosts
    @import 'Partials/AllPostsCta/_style'
```

## Automatic Post Teaser list by selecting a post type
add partial `Partials/AllPostsCta/*.*`

```json
{
  "layout": {
    "name": "listPosts",
    "label": "List Posts",
    "sub_fields": [
      {
        "label": "PostType",
        "name": "postType",
        "type": "select",
        "choices": {
          "post": "Post"
        },
        "default_value": "",
        "allow_null": 0,
        "multiple": 0,
        "ui": 1,
        "ajax": 0
      },
      {
        "label": "Post Count",
        "name": "postCount",
        "type": "number",
        "min": 0,
        "step": 1
      },
      {
        "label": "Show all posts cta label",
        "name": "allPostsCtaLabel",
        "type": "text"
      },
      {
        "label": "Show all posts cta link",
        "name": "allPostsCtaLink",
        "type": "post_object",
        "allow_null": 1,
        "multiple": 0,
        "return_format": "object",
        "ui": 1
      }
    ]
  }
}
```

## Manual Post Teaser selection
add partial `Partials/AllPostsCta/*.*`

`fields.json`
```json
{
  "layout": {
    "name": "listPosts",
    "label": "List Posts",
    "sub_fields": [
      {
        "label": "Posts",
        "name": "posts",
        "type": "post_object",
        "allow_null": 1,
        "multiple": 1,
        "return_format": "object",
        "ui": 1,
        "post_type": ["post"]
      },
      {
        "label": "Show all posts cta label",
        "name": "allPostsCtaLabel",
        "type": "text"
      },
      {
        "label": "Show all posts cta link",
        "name": "allPostsCtaLink",
        "type": "post_object",
        "allow_null": 1,
        "multiple": 0,
        "return_format": "object",
        "ui": 1
      }
    ]
  }
}
```

`functions.php`
```php
<?php

namespace Flynt\Components\ListPosts;

use Flynt\Utils\Component;
use Timber\Timber;

add_filter('Flynt/addComponentData?name=ListPosts', function ($data, $parentData) {
    if (isset($data['postType'])) {
        $args = [
            'post_status' => 'publish',
            'post_type' => $data['postType']
        ];
        $args['numberposts'] = !empty($data['postCount']) ? $data['postCount'] : 10;

        $data['posts'] = Timber::get_posts($args);
        $data['posts'] = addDataToAllPosts($data['posts']);
    }

    return $data;
}, 10, 2);

function addDataToAllPosts($posts) {
    if (is_array($posts)) {
        $posts = array_map(function ($post) {
            $post->excerpt = $post->get_preview(50, false, $data['readMoreLabel']);
            return $post;
        }, $posts);
    }
    return $posts;
}
```

## Archive page post teasers
`functions.php`
```php
<?php
add_filter('Flynt/addComponentData?name=ListPosts', function ($data, $parentData) {
    $data['pagination'] = (isset($parentData['pagination'])) ? $parentData['pagination'] : null;
    if (!isset($data['posts']) && isset($parentData['posts'])) {
        $data['posts'] = $parentData['posts'];
    }
    return $data;
}, 10, 2);
```
