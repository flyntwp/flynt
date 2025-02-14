<?php

namespace Flynt\Utils;

use Flynt\Api;
use Flynt\ComponentManager;
use Timber\Timber;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\Extension\CoreExtension;
use Twig\TwigFunction;

/**
 * Creates the render components function to use them in Twig files.
 */
class TwigExtensionRenderComponent extends AbstractExtension
{
    /**
     *  Returns a list of functions to add to the existing list.
     *
     * @return array An array of filters
     */
    public function getFunctions()
    {
        return [
            new TwigFunction(
                'renderComponent',
                [$this, 'renderComponent'],
                ['needs_environment' => true, 'needs_context' => true, 'is_safe' => ['all']]
            ),
        ];
    }

    /**
     * Render component.
     *
     * @param Environment $twigEnvironment Twig environment.
     * @param array $context Twig context.
     * @param string|array $componentName The name of the component.
     * @param array|null $data The data of the component.
     * @param boolean $withContext Whether to pass the context to the component.
     * @param boolean $ignoreMissing Whether to ignore missing components.
     * @param boolean $sandboxed Whether to sandbox the component.
     *
     * @return string The rendered component.
     */
    public function renderComponent(Environment $twigEnvironment, array $context, $componentName, ?array $data = [], bool $withContext = false, bool $ignoreMissing = false, bool $sandboxed = false)
    {

        $data ??= [];

        if (is_array($componentName)) {
            $data = array_merge($componentName, $data);
            $componentName = ucfirst($data['acf_fc_layout']);
        }
        $timberContext = $withContext ? $context : Timber::context();

        $fn = function ($output, $componentName, $data) use ($twigEnvironment, $timberContext, $withContext, $ignoreMissing, $sandboxed) {
            $componentManager = ComponentManager::getInstance();
            $filePath = $componentManager->getComponentFilePath($componentName, 'index.twig');
            $relativeFilePath = ltrim(str_replace(get_template_directory(), '', $filePath), '/');

            if (!is_file($filePath)) {
                trigger_error("Template not found: {$filePath}", E_USER_WARNING);
                return '';
            }

            $loader = $twigEnvironment->getLoader();
            $loaderPaths = $loader->getPaths();

            $loader->addPath(dirname($filePath));

            $output = CoreExtension::include($twigEnvironment, $timberContext, $relativeFilePath, $data, true, $ignoreMissing, $sandboxed); //TODO: CoreExtension::include: review withContext parameter 

            $loader->setPaths($loaderPaths);

            return $output;
        };

        add_filter('Flynt/renderComponent', $fn, PHP_INT_MIN, 3);

        $output = Api::renderComponent($componentName, $data);

        remove_filter('Flynt/renderComponent', $fn, PHP_INT_MIN);

        return $output;
    }
}
