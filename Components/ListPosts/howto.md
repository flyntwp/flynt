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

`Partials/Tags/_style.scss`
```scss
.tags {
  list-style: none;
  margin: 0;
  padding: 0;

  &-item {
    float: left;
    margin-right: 10px;
  }
}

```

`style.scss`
```scss
[is=flynt-list-posts] {
  .listPosts {
    @import 'Partials/Tags/_style';
  }
}
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

`Partials/Categories/_style.scss`
```scss
.categories {
  list-style-type: none;
  margin: 0;
  padding: 0;

  &-item {
    float: left;
    margin-right: 10px;
  }
}
```

`style.scss`
```scss
[is=flynt-list-posts] {
  .listPosts {
    @import 'Partials/Categories/_style';
  }
}
```

`Partials/PostTeaser/index.twig`
```twig
{% include 'Partials/Categories/index.twig' %}
```
