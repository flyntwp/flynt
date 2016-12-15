# Glossary

## Component
A component is a self-contained building-block. Each component has its own scope. As such, each component is kept within its own folder which contains everything it requires; the layout, the back-end field setup, all necessary Wordpress filter and hook logic, scripting, styles, and any other relevant static assets:

```
  MyExampleComponent/
  ├── assets/
  |   ├── exampleImage.jpg
  |   └── exampleIcon.svg
  ├── index.twig
  ├── functions.php
  ├── fields.json
  ├── style.styl
  ├── script.js
  ├── README.md
```

Building components is a sustainable process, meaning every component you develop can be reused within or in another project; increasing your headstart with every new Flynt project.

## Area
Since components are self-contained, areas provide a way to stack our building-blocks together. An area is simply a location within a component where it is possible to add other components.

<div class="alert alert-steps">
  <h2>Next Steps</h2>

  <p>That's all there is to know! We can now get started with building our first component.</p>

  <p><a href="hello-world.md" class="btn btn-primary">Get started</a></p>
</div>
