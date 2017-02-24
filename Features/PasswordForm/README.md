# Password Form (Flynt Feature)

Twig Version of the default WordPress password form.

Customize the template, add styles and scripts to your liking.

## Note

WordPress suggests to change the password form by hooking into `the_password_form` ([Using Password Protection](https://codex.wordpress.org/Using_Password_Protection#Password_Form_Text)). This is done here as well. However, when you do this you will not have a reference to the post id that was potentially passed to `get_the_password_form`.

If you want to change the behaviour, have a look at [Snippets](./snippets.md) for instructions.
