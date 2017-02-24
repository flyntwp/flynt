# Snippets

## Post specific password form

Replace the `add_filter` function call in this feature's **functions.php** with

```php
@codingStandardsIgnoreLine
function getPasswordForm ($postId = null) {
  $context = Timber::get_context();
  $post = new Post($postId);
  $context['post'] = $post;

  $output =  Timber::fetch('index.twig', $context);

  return apply_filters('the_password_form', $output);
}
```

This enables you to use `\Flynt\Features\PasswordForm\getPasswordForm($postId)` anywhere in your project. The default filter `the_password_form` will not be changed, however.

For example change the `getPasswordContext` function in **Components/MainTemplate/functions.php** to

```php
function getPasswordContext ($postId) {
  $passwordProtected = post_password_required($postId);
  return [
    'passwordProtected' => $passwordProtected,
    'passwordForm' => $passwordProtected ? \Flynt\Features\PasswordForm\getPasswordForm() : ''
  ];
}
```
