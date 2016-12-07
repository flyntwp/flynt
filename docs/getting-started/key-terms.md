# 1. Key Terms

There are a couple of key concepts that need to be understood before getting started.

## Modules
A module is a self-contained building-block. Each module has its own scope. As such, each module is kept within its own folder which contains everything it requires; the layout, the back-end field setup, all necessary Wordpress filter and hook logic, scripting, styles, and any other relevant static assets:

```
  MyExampleModule/
  ├── Assets/
  |   ├── exampleImage.jpg
  |   └── exampleIcon.svg
  ├── index.php.pug
  ├── functions.php
  ├── fields.json
  ├── style.styl
  ├── script.js
  ├── README.md
```

Building modules is a sustainable process, meaning every module you develop can be reused within or in another project; increasing your headstart with every new Flynt project.

This series of tutorials will demonstrate the process of building a module piece by piece.

## Areas
Since modules are self-contained, areas provide a way to stack our building-blocks together. An area is simply a location within a module where it is possible to add other modules.

<div class="alert alert-steps">
  <h2>Next Steps</h2>

  <p>That's all there is to know! We can now get started with building our first module.</p>

  <p><a href="basic-module.md" class="btn btn-primary">Get started with section 2</a></p>
</div>
