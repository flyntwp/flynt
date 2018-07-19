# HowTo

## Configure Feature

Add the lodash functions you want to use globally on your project.

`Features/Lodash/script.js`
```javascript
window._ = {
  debounce: require('lodash/debounce'),
  find: require('lodash/find')
}
```

## Component

Add the lodash dependency to the component you want to use it in.

`Components/ComponentName/functions.php`
```php
<?php

namespace Flynt\Components\ComponentName;

use Flynt\Features\Components\Component;

...

Component::enqueueAssets('ComponentName', [
    [
        'type' => 'script',
        'name' => 'Flynt/Features/Lodash',
        'path' => 'Features/Lodash/script.js'
    ]
]);
```

Add the underscore variable to the component's script scope and use any previously registered lodash function.

`Components/ComponentName/script.js`
```javascript
import $ from 'jquery'

const _ = window._

class ComponentName extends window.HTMLDivElement {
  constructor (self) {
    self = super(self)
    self.$ = $(self)
    self.resolveElements()
    return self
  }

  resolveElements () {
    this.$window = $(window)
  }

  connectedCallback () {
    this.$window.on('resize', _.debounce(this.someFunction.bind(this), 250))
  }

  someFunction () {
    console.log('someFunction')
  }
}

```
