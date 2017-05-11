Title: Slider Media

----

Category: slider

----

Tags: slider, media, image, oembed, title

----

Text: oembed Slider with Image and oembed-Media functionality. Slides also support titles/captions.

----

# Fixed Height

If you want to use fixed height for this component, enable the option in the stylesheet and add the required data-attribute for objectfit-polyfill as an attribute for the picturefill mixin.


### Normal Image (Adaptive Height)
```jade
+picture($image, 'sliderMedia')
```

### Fixed Image (Fixed Height)
```jade
+picture($image, 'sliderMedia')(data-object-fit='cover' data-object-fit-position='50% 50%')
```

You can get a list of data-attributes on the [polyfill repository](https://github.com/constancecchen/object-fit-polyfill#usage).
