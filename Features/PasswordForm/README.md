# Password Form (Flynt Feature)

Twig Version of the default WordPress password form.

Customize the template, add styles and scripts to your liking.

## Note

WordPress suggests to change the password form by hooking into `the_password_form` ([Using Password Protection](https://codex.wordpress.org/Using_Password_Protection#Password_Form_Text)). This is done here as well. However, when you do this you will not have a reference to the post id that was potentially passed to `get_the_password_form`.

If you want to change the behaviour, comment out the `add_filter` method call in this features **functions.php** and uncomment `getPasswordForm`. Then you will be able to use `\Flynt\Features\PasswordForm\getPasswordForm($postId)` anywhere in your project. The default filter `the_password_form` will not be changed, however.
