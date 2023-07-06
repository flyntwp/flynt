if (window.acf) {
  const { fieldName, labels } = window.FeatureComponentName

  function createAction (id) {
    const $action = document.createElement('a')
    $action.setAttribute('href', '#')
    $action.setAttribute('data-index', id)
    $action.setAttribute('data-name', 'flynt-component-name-action')
    $action.setAttribute('title', labels.tooltip)
    $action.classList.add('flyntComponentName-icon', 'acf-icon', '-pencil', 'small', 'light', 'acf-js-tooltip')
    return $action
  }

  function createInput (name) {
    const $input = document.createElement('input')
    $input.setAttribute('type', 'text')
    $input.setAttribute('placeholder', labels.placeholder)
    $input.setAttribute('name', 'flynt-component-name-field')
    $input.setAttribute('value', name)
    $input.classList.add('flyntComponentName-field')
    return $input
  }

  function setPositions ($layout) {
    const $screenshotLabel = $layout.querySelector('.flyntComponentScreenshot-label')
    const $controls = $layout.querySelector('.acf-fc-layout-controls')
    const controlsRect = $controls.getBoundingClientRect()
    const layoutRect = $layout.getBoundingClientRect()
    const screenshotLabelRect = $screenshotLabel.getBoundingClientRect()

    const left = screenshotLabelRect.left - layoutRect.left + screenshotLabelRect.width
    const maxWidth = controlsRect.width + left

    $layout.style.setProperty('--flynt-component-name-offset', `${left}px`)
    $layout.style.setProperty('--flynt-component-name-max-width', `${maxWidth}px`)
  }

  window.acf.addAction('ready_field/type=flexible_content', function (field) {
    const $field = field.$el[0]

    $field.querySelectorAll('.layout').forEach(function ($layout) {
      /*
       * Do this only once to prevent multiple actions being added
       * with nested layouts.
       */
      if ($layout.getAttribute('data-has-flynt-component-name')) {
        return
      }

      $layout.setAttribute('data-has-flynt-component-name', true)

      const componentName = $layout.querySelector(`[data-name="${fieldName}"] input`)?.value
      const $action = createAction($layout.getAttribute('data-id'))
      const $input = createInput(componentName)

      const $flyntComponentName = document.createElement('div')
      $flyntComponentName.classList.add('flyntComponentName')
      $flyntComponentName.setAttribute('data-has-name', Boolean(componentName))

      $flyntComponentName.append($action)
      $flyntComponentName.append($input)

      setPositions($layout)

      $layout.prepend($flyntComponentName)
    })
  })

  window.acf.addAction(`new_field/name=${fieldName}`, function (field) {
    const $field = field.$el[0]
    const $layout = $field.closest('.layout')
    setPositions($layout)
  })

  document.addEventListener('click', function (event) {
    if (event.target.classList.contains('flyntComponentName-icon')) {
      event.preventDefault()
      const $icon = event.target
      $icon.closest('.flyntComponentName').setAttribute('data-has-name', true)
      $icon.nextElementSibling.focus()
    }
  })

  document.addEventListener('input', function (event) {
    if (event.target.getAttribute('name') === 'flynt-component-name-field') {
      const name = event.target.value
      const $layout = event.target.closest('.layout')
      const $componentName = $layout.querySelector(`[data-name="${fieldName}"] input`)
      $componentName.setAttribute('value', name)
    }
  })
}
