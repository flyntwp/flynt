# Snippets

## Adding a optional partial

This component includes partials which can be added or removed easily

* SinglePost
  * PostHeader
    * PostDate
    * PostAuthor
  * PostContent
  * PostFooter
    * PostCategories
    * PostTags

Twig (PostHeader for example):
```twig
<header class="postHeader">
  <h2 class="postHeader-title">
    <a class="postHeader-link" href="{{ post.permalink }}" title="{{ readMoreLabel }}: {{ post.title }}">{{ post.title }}</a>
  </h2>
  <p class="postHeader-meta">
    {% include 'partials/PartialName/index.twig' %}
  </p>
</header>
```

Stylus:
```stylus
.flyntComponent[is="flynt-list-posts"]
  *,
  *:before,
  *:after
    box-sizing: border-box

  .postList
    center($containerMaxWidth, $gutterWidth)

  @import 'partials/PartialName/*.styl'
```
