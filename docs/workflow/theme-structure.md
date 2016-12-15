# Theme Structure

## Folder Structure

Overview of theme folder structure.

```
|── config
|──── customPostTypes
|──── fieldGroups
|──── templates
|──── wordpress
└── dist
└── lib
└── Components
└── templates
└── functions.php
└── index.php
└── screenshot.png
└── styles.css
└── bower.json
└── package.json
```

## Page Templates
All template files in Flynt can be found under the theme root, in the `templates` directory.

By default, the following standard Wordpress templates are included. These templates follow the normal [Wordpress Template Hierarchy](https://developer.wordpress.org/themes/basics/template-hierarchy/), and work in exactly the same way:
- `index.php`
- `page.php`
- `single.php`
- `home.php`
- `archive.php`
- `404.php`
- `search.php`

By default, the following custom page templates are also included:
- `plugin-inactive.php` - Displayed when the required Flynt plugin is disabled.
