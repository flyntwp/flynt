# TinyMCE (Flynt Feature)

Cleans up TinyMCE Buttons to show all relevant buttons on the first bar. Adds an easy to configure way to change these defaults (via JSON file).

## Updating global TinyMce settings using the JSON config
By updating the `Features/TinyMce/config.json` file you can easily add new **Block Formats**, **Style Formats** and **Toolbars** for all Wysiwyg editors in your project.

## Editor Toolbars

The MCE Buttons that show up by default are specified by the `toolbars` section in the `Features/TinyMce/config.json` file.
You can modify the settings for all Wysiwyg toolbars (all over your project).

```json
{
  "toolbars": {
    "default": [
      [
        "formatselect",
        "styleselect",
        "bold",
        "italic",
        "underline",
        "strikethrough",
        "|",
        "bullist",
        "numlist",
        "|",
        "link",
        "unlink",
        "|",
        "wp_more",
        "pastetext",
        "removeformat",
        "|",
        "undo",
        "redo",
        "fullscreen"
      ]
    ]
  }
}
```

Do your modifications there by adding/deleting the buttons you need.
You can also reactivate the second bar if needed.

To show the toggle visibilty button of the Second Bar you need to add this button to the __First Bar__ `'wp_adv'`

You can call any toolbar defined in this section inside your ACF configuration in lowercase:

**Example**:<br>
`"toolbar": "customtoolbar"`

## Block Formats

You can configure the block formats in the `blockformats` section in the `Features/TinyMce/config.json` file.

```json
{
  "blockformats": {
    "Paragraph": "p",
    "Heading 1": "h1",
    "Heading 2": "h2",
    "Heading 3": "h3",
    "Heading 4": "h4",
    "Heading 5": "h5",
    "Heading 6": "h6"
  }
}
```

## Editor Styles

You can also create new **styles** globally, but first you need the `styleselect` in the active toolbar to be able to register your own custom styles.
Once that it is done, you can add custom styles simply by editing the `styleformats` section:

```json
{
  "styleformats": [
    {
      "title": "Button Primary",
      "classes": "a.btn.btn-primary",
      "selector": "a"
    }
  ]
}
```
