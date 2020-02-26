<?php

namespace Flynt;

class ComponentManager
{
    protected $components = [];
    protected static $instance = null;

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * clone
     *
     * Prevent cloning with 'protected' keyword
     */
    protected function __clone()
    {
    }

    /**
     * constructor
     *
     * Prevent instantiation with 'protected' keyword
     */
    protected function __construct()
    {
    }

    public function registerComponent($componentName, $componentPath = null)
    {
        // check if component already registered
        if ($this->isRegistered($componentName)) {
            trigger_error("Component {$componentName} is already registered!", E_USER_WARNING);
            return false;
        }

        // register component / require functions.php
        $componentPath = trailingslashit(apply_filters('Flynt/componentPath', $componentPath, $componentName));

        // add component to internal list (array)
        $this->add($componentName, $componentPath);

        do_action('Flynt/registerComponent', $componentName);
        do_action("Flynt/registerComponent?name={$componentName}", $componentName);

        return true;
    }

    public function getComponentFilePath($componentName, $fileName = 'index.php')
    {
        $componentDir = $this->getComponentDirPath($componentName);

        if (false === $componentDir) {
            return false;
        }

        // dir path already has a trailing slash
        $filePath = $componentDir . $fileName;

        return is_file($filePath) ? $filePath : false;
    }

    public function getComponentDirPath($componentName)
    {
        $dirPath = $this->get($componentName);

        // check if dir exists
        if (!is_dir($dirPath)) {
            return false;
        }

        return $dirPath;
    }

    protected function add($name, $path)
    {
        $this->components[$name] = $path;
        return true;
    }

    public function get($componentName)
    {
        // check if component exists / is registered
        if (!$this->isRegistered($componentName)) {
            trigger_error("Cannot get component: Component '{$componentName}' is not registered!", E_USER_WARNING);
            return false;
        }

        return $this->components[$componentName];
    }

    public function remove($componentName)
    {
        unset($this->components[$componentName]);
    }

    public function getAll()
    {
        return $this->components;
    }

    public function removeAll()
    {
        $this->components = [];
    }

    public function isRegistered($componentName)
    {
        return array_key_exists($componentName, $this->components);
    }
}
