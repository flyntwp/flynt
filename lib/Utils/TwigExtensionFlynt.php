<?php

namespace Flynt\Utils;

use Flynt\ComponentManager;
use Twig_Environment;
use Twig_Extension;
use Twig\TwigFunction;

class TwigExtensionFlynt extends Twig_Extension
{

    public function getName()
    {
        return 'twig_extension_flynt';
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('renderComponent', [$this, 'renderComponent'], array('needs_environment' => true, 'needs_context' => true, 'is_safe' => array('all'))),
        ];
    }

    public function renderComponent(Twig_Environment $env, $context, $componentName, $data = [], $withContext = true, $ignoreMissing = false, $sandboxed = false)
    {
        $data = $data === false ? [] : $data;

        if (is_array($componentName)) {
            $data = array_merge($componentName, $data);
            $componentName = ucfirst($data['acf_fc_layout']);
        }
        $data = $this->getComponentData($data, $componentName);

        $componentManager = ComponentManager::getInstance();
        $templateFilename = apply_filters('Flynt/TimberLoader/templateFilename', 'index.twig');
        $templateFilename = apply_filters("Flynt/TimberLoader/templateFilename?name=${componentName}", $templateFilename);
        $filePath = $componentManager->getComponentFilePath($componentName, $templateFilename);
        $relativeFilePath = ltrim(str_replace(get_template_directory(), '', $filePath), '/');

        if (!is_file($filePath)) {
            trigger_error("Template not found: {$filePath}", E_USER_WARNING);
            return '';
        }

        $loader = $env->getLoader();

        $loaderPaths = $loader->getPaths();

        $loader->addPath(dirname($filePath));

        $output = twig_include($env, $context, $relativeFilePath, $data, $withContext, $ignoreMissing, $sandboxed);

        $loader->setPaths($loaderPaths);

        $output = apply_filters(
            'Flynt/renderComponent',
            $output,
            $componentName,
            $data
        );

        return $output;
    }

    protected function getComponentData($data, $componentName)
    {
        $data = apply_filters(
            'Flynt/addComponentData',
            $data,
            $componentName
        );

        return $data;
    }
}
