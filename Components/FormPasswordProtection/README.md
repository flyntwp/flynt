# Form Password Protection

Twig version of the default WordPress password form. It's done by hooking into `the_password_form`, [as suggested by WordPress](https://wordpress.org/support/article/using-password-protection/#password-form-text). However, this will not receive the post id that may have been passed to `get_the_password_form`.
