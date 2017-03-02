# Snippets

## Adding a list of pages

index.twig
```twig
<div is="flynt-pagination-buttons" class="flyntComponent">
  <div class="paginationButtons">
    <div class="paginationButtons-prevWrapper">
      {% if pagination.prev %}
        <a href="{{pagination.prev.link}}" class="paginationButtons-prevButton btn btn-primary">Previous</a>
      {% endif %}
    </div>
    {% include 'partials/ButtonList/index.twig' %}
    <div class="paginationButtons-nextWrapper">
      {% if pagination.next %}
        <a href="{{ pagination.next.link }}" class="paginationButtons-nextButton btn btn-primary">Next</a>
      {% endif %}
    </div>
  </div>
</div>
```

style.styl
```
@import '_config.styl'

.flyntComponent[is="flynt-pagination-buttons"]
  *,
  *:before,
  *:after
    box-sizing: border-box

  .paginationButtons
    center($containerMaxWidth, $gutterWidth)
    padding-bottom: 15px
    padding-top: 15px

    &-prevWrapper
      column(1/3, $gutter: 2)
      min-height: 1px

    &-nextWrapper
      column(1/3, $gutter: 2)
      min-height: 1px
      text-align: right

  @import "partials/ButtonList/style.styl"
```
