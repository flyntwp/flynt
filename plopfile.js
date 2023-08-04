module.exports = function (plop) {
  plop.load("plop-action-copy");

  // Produces acf name e.g. 'sliderImage' from 'SliderImage'
  plop.setHelper("componentAcfName", function (componentName) {
    return componentName.charAt(0).toLowerCase() + componentName.slice(1);
  });

  // Produces component name in title case e.g. 'Slider Image' from 'SliderImage'
  plop.setHelper("componentTitleCase", function (componentName) {
    return componentName.replace(/([A-Z])/g, " $1").trim();
  });

  // Produces component name e.g. 'Slider: Image' from 'SliderImage'
  plop.setHelper("componentTitle", function (componentName) {
    var titleCase = componentName.replace(/([A-Z])/g, " $1").trim();
    var arr = titleCase.split(/(?=[A-Z])/);
    return arr.shift().trim() + ": " + arr.join("");
  });

  plop.setHelper("curlyOpen", function () {
    return "{{";
  });

  plop.setHelper("curlyClose", function () {
    return "}}";
  });

  plop.setHelper("tilde", function () {
    return "~";
  });

  plop.setGenerator("component", {
    description: "New Flynt component",
    prompts: [
      {
        type: "input",
        name: "componentsPath",
        message: "Path to components folder",
        default: "Components",
      },
      {
        type: "list",
        name: "componentCategory",
        message: "What category does your new component fit best?",
        choices: [
          {
            name: "Accordion",
            value: "Accordion",
          },
          {
            name: "Block (A component without any further specification)",
            value: "Block",
          },
          {
            name: "Calendar (A table for date related data)",
            value: "Calendar",
          },
          {
            name: "Document",
            value: "Document",
          },
          {
            name: "Form",
            value: "Form",
          },
          {
            name: "Grid (Specific count of items per row)",
            value: "Grid",
          },
          {
            name: "Hero (Large section header)",
            value: "Hero",
          },
          {
            name: "Layout (Contains different component areas)",
            value: "Layout",
          },
          {
            name: "List (Items in a horizontal or vertical list)",
            value: "List",
          },
          {
            name: "Map",
            value: "Map",
          },
          {
            name: "Modal",
            value: "Modal",
          },
          {
            name: "Navigation",
            value: "Navigation",
          },
          {
            name: "Sidebar",
            value: "Sidebar",
          },
          {
            name: "Slider",
            value: "Slider",
          },
          {
            name: "Table",
            value: "Table",
          },
          {
            name: "Tabs",
            value: "Tabs",
          },
          {
            name: "Video",
            value: "Video",
          },
          {
            name: "Custom (Manually specify a category within the component name)",
            value: "Custom",
          },
        ],
      },
      {
        type: "input",
        name: "componentName",
        message: "Name of the new component in UpperCamelCase",
        validate: function (input) {
          if (!input.length) {
            return "Please enter component name!";
          }
          var validStringRegEx = /^[A-Z][A-Za-z]*$/g;
          if (!validStringRegEx.test(input)) {
            return "Invalid component name";
          }
          return true;
        },
        transformer: function (input, answers) {
          if (input && answers.componentCategory !== "Custom") {
            return answers.componentCategory + input;
          }
          return input;
        },
      },
      {
        type: "list",
        name: "jsStrategy",
        message:
          "Javascript loading strategy (see https://github.com/flyntwp/flynt#javascript-modules)?",
        choices: [
          {
            name: "No Javascript",
            value: "noJavascript",
          },
          {
            name: "On load",
            value: "load",
          },
          {
            name: "On idle",
            value: "idle",
          },
          {
            name: "On visible",
            value: "visible",
          },
        ],
        default: "load",
      },
      {
        when: function (response) {
          return response.jsStrategy !== "noJavascript";
        },
        type: "list",
        name: "jsMediaQuery",
        message: "Load Javascript only on matching media query?",
        choices: [
          {
            name: "No, load on all devices",
            value: "always",
          },
          {
            name: "Yes, add 'max-width' media query",
            value: "max-width",
          },
          {
            name: "Yes, add 'min-width' media query",
            value: "min-width",
          },
        ],
        default: "always",
      },
      {
        when: function (response) {
          return (
            response.jsStrategy !== "noJavascript" &&
            response.jsMediaQuery !== "always"
          );
        },
        type: "input",
        name: "jsMediaQueryBreakpoint",
        message: "JS media query breakpoint in px",
        default: "1024",
        validate: function (input) {
          if (!input.length) {
            return "Please enter a breakpoint!";
          }
          var validStringRegEx = /^[0-9]*$/g;
          if (!validStringRegEx.test(input)) {
            return "Invalid breakpoint value";
          }
          return true;
        },
      },
      {
        type: "list",
        name: "addGlobalOptions",
        message: "Add 'Options::addGlobal' section to functions.php?",
        choices: [
          {
            name: "Yes",
            value: "yes",
          },
          {
            name: "No",
            value: "no",
          },
        ],
        default: "yes",
      },
      {
        type: "list",
        name: "addTranslatableOptions",
        message: "Add 'Options::addTranslatable' section to functions.php?",
        choices: [
          {
            name: "Yes",
            value: "yes",
          },
          {
            name: "No",
            value: "no",
          },
        ],
        default: "yes",
      },
    ],
    actions: function (data) {

      var componentName =
        data.componentCategory !== "Custom"
          ? data.componentCategory + data.componentName
          : data.componentName;

      var actions = [];

      var componentAtts = [];

      if (data.jsStrategy !== "noJavascript") {
        componentAtts.push("load:on=" + '"' + data.jsStrategy + '"');
      }

      if (
        data.jsStrategy !== "noJavascript" &&
        data.jsMediaQuery !== "always" &&
        data.jsMediaQueryBreakpoint
      ) {
        componentAtts.push(
          "load:on:media=" +
            '"(' +
            data.jsMediaQuery +
            ": " +
            data.jsMediaQueryBreakpoint +
            'px)"'
        );
      }

      // index.twig
      actions.push({
        type: "add",
        path: "{{componentsPath}}/" + componentName + "/index.twig",
        templateFile: "plop_templates/index.hbs",
        data: {
          name: componentName,
          withJs: data.jsStrategy !== "noJavascript",
          componentAtts: componentAtts.join(" "),
        },
      });

      // functions.php
      actions.push({
        type: "add",
        path: "{{componentsPath}}/" + componentName + "/functions.php",
        templateFile: "plop_templates/functions.hbs",
        data: {
          name: componentName,
          addGlobals: data.addGlobalOptions === "yes",
          addTranslatables: data.addTranslatableOptions === "yes",
          hasAnyOptions: data.addGlobalOptions === "yes" || data.addTranslatableOptions === "yes",
        },
      });

      // _style.scss
      actions.push({
        type: "add",
        path: "{{componentsPath}}/" + componentName + "/_style.scss",
        templateFile: "plop_templates/style.hbs",
        data: {
          name: componentName,
        },
      });

      // script.js
      if (data.jsStrategy !== "noJavascript") {
        actions.push({
          type: "add",
          path: "{{componentsPath}}/" + componentName + "/script.js",
          templateFile: "plop_templates/script.hbs",
        });
      }

      // README.md
      actions.push({
        type: "add",
        path: "{{componentsPath}}/" + componentName + "/README.md",
        templateFile: "plop_templates/README.hbs",
        data: {
          name: componentName,
        },
      });

      // screenshot.png
      actions.push({
        type: "copy",
        src: "plop_templates/screenshot.png",
        dest: "{{componentsPath}}/" + componentName + "/screenshot.png",
      });
      return actions;
    },
  });
};
