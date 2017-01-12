# Remove Editor (Flynt Feature)

Removes `the_content` area (editor) from the Wordpress backend. Since Flynt uses ACF by default, this area is not needed. If you need to use this editor in your project, simply remove the `add_theme_support('flynt-remove-editor')` line from your `lib/Init.php` file.
