<?php

namespace Flynt;

/**
 * Provides a set of methods that are used to register and get
 * information about components.
 */
class ComponentManager
{
    /**
     * The internal list (array) of components.
     *
     * @var array
     */
    protected $components = [];

    /**
     * The instance of the class.
     *
     * @var ComponentManager
     */
    protected static $instance;

    /**
     * Get the instance of the class.
     *
     * @return ComponentManager
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Constructor.
     *
     * Prevent instantiation with 'protected' keyword
     *
     * @return void
     */
    protected function __construct()
    {
    }

    /**
     * Register a component.
     *
     * @param string $componentName The name of the component.
     * @param string $componentPath The path to the component.
     */
    public function registerComponent(string $componentName, ?string $componentPath = null): bool
    {
        // Check if component already registered.
        if ($this->isRegistered($componentName)) {
            trigger_error("Component {$componentName} is already registered!", E_USER_WARNING);
            return false;
        }

        // Register component / require functions.php.
        $componentPath = trailingslashit(apply_filters('Flynt/componentPath', $componentPath, $componentName));

        // Add component to internal list (array).
        $this->add($componentName, $componentPath);

        do_action('Flynt/registerComponent', $componentName);
        do_action("Flynt/registerComponent?name={$componentName}", $componentName);

        return true;
    }

    /**
     * Get the path to a component file.
     *
     * @param string $componentName The name of the component.
     * @param string $fileName The name of the file.
     *
     * @return string|boolean
     */
    public function getComponentFilePath(string $componentName, string $fileName = 'index.php')
    {
        $componentDir = $this->getComponentDirPath($componentName);

        if (false === $componentDir) {
            return false;
        }

        // Dir path already has a trailing slash.
        $filePath = $componentDir . $fileName;

        return is_file($filePath) ? $filePath : false;
    }

    /**
     * Get the path to a component directory.
     *
     * @param string $componentName The name of the component.
     *
     * @return string|boolean
     */
    public function getComponentDirPath(string $componentName)
    {
        $dirPath = $this->get($componentName);

        // Check if dir exists.
        if (!is_dir($dirPath)) {
            return false;
        }

        return $dirPath;
    }

   /**
    * Add a component to the internal list (array).
    *
    * @param string $name The name of the component.
    * @param string $path The path to the component.
    */
    protected function add(string $name, string $path): bool
    {
        $this->components[$name] = $path;
        return true;
    }

    /**
     * Get a component from the internal list (array).
     *
     * @param string $componentName The name of the component.
     *
     * @return string|boolean
     */
    public function get(string $componentName)
    {
        // Check if component exists / is registered.
        if (!$this->isRegistered($componentName)) {
            trigger_error("Cannot get component: Component '{$componentName}' is not registered!", E_USER_WARNING);
            return false;
        }

        return $this->components[$componentName];
    }

    /**
     * Remove a component from the internal list (array).
     *
     * @param string $componentName The name of the component.
     */
    public function remove(string $componentName): void
    {
        unset($this->components[$componentName]);
    }

    /**
     * Get all components from the internal list (array).
     *
     * @return array
     */
    public function getAll()
    {
        return $this->components;
    }

    /**
     * Remove all components from the internal list (array).
     */
    public function removeAll(): void
    {
        $this->components = [];
    }

    /**
     * Check if a component is registered.
     *
     * @param string $componentName The name of the component.
     */
    public function isRegistered(string $componentName): bool
    {
        return array_key_exists($componentName, $this->components);
    }

    /**
     * Get all components that have a script.js file.
     */
    public function getComponentsWithScript(): array
    {
        $componentsWithScripts = [];
        foreach ($this->components as $componentName => $componentPath) {
            $componentPath = str_replace('/dist/', '/', $componentPath);
            $relativeComponentPath = trim(str_replace(get_template_directory() . '/Components/', '', $componentPath), '/');
            if (file_exists($componentPath . '/script.js')) {
                $componentsWithScripts[$componentName] = $relativeComponentPath;
            }
        }

        return $componentsWithScripts;
    }
}
