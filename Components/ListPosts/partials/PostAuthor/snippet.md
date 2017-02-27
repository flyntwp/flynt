# Snippets

## Using the username instead of first_name and last_name

```twig
<span class="postAuthor">
  <a href="{{ post.author.url }}" title="{{ post.author.name }}" class="postAuthor-link">{{ post.author.name }}</a>
</span>
```
