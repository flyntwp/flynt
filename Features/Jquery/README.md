# jQuery (Flynt Feature)

Loads jQuery before the closing body tag by default. Can be overwritten if there is a script in the head with jQuery as a dependency.

If the Asset utility has `loadFromCdn` set to true, it will load from Google's CDN falling back to the default WordPress script. This setting can be changed in the `lib/Init.php` file inside the `initTheme` function.
