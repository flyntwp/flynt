Title: Image

----

Category: image

----

Tags: image, hero, header

----

Text: Image for hero modules, can be set to fixed height or adaptive height.

----

# Fixed Height

If you want to use fixed height for this module, enable the option in the stylesheet and add the required data-attribute for objectfit-polyfill as an attribute for the picturefill mixin.


### Normal Image (Adaptive Height)
```jade
+picture($image, 'imageHero')
```

### Fixed Image (Fixed Height)
```jade
+picture($image, 'imageHero')(data-object-fit='cover' data-object-fit-position='50% 50%')
```

You can get a list of data-attributes on the [polyfill repository](https://github.com/constancecchen/object-fit-polyfill#usage).
