# Feature Password Form

Twig version of the default WordPress password form.

It's done by hooking into `the_password_form`, [as suggested by WordPress](https://wordpress.org/support/article/using-password-protection/#password-form-text). However, when you do this you will not have a reference to the post id that was potentially passed to `get_the_password_form`.
