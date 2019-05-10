<?php

namespace Flynt\Utils;

use Flynt\ComponentManager;
use Flynt\Defaults;
use Twig_Environment;
use Twig_Extension;
use Twig_SimpleFunction;

class TwigExtensionFlynt extends Twig_Extension
{

    public function getName()
    {
        return 'twig_extension_flynt';
    }

    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('renderComponent', [$this, 'renderComponent'], array('needs_environment' => true, 'needs_context' => true, 'is_safe' => array('all'))),
            new Twig_SimpleFunction('renderFlexibleContent', [$this, 'renderFlexibleContent'], array('needs_environment' => true, 'needs_context' => true, 'is_safe' => array('all'))),
        );
    }

    public function renderFlexibleContent(Twig_Environment $env, $context, $fields, $withContext = true, $ignoreMissing = false, $sandboxed = false)
    {
        if (!Defaults::$useGutenberg) {
            $output = '';
            foreach ((empty($fields) ? [] : $fields) as $field) {
                $output .= $this->renderComponent($env, $context, ucfirst($field['acf_fc_layout']), $field, $withContext, $ignoreMissing, $sandboxed);
            }
            return $output;
        } else {
            $post = get_post();
            $content = $post->post_content;
            $content = str_replace(']]>', ']]&gt;', $content);
            $content = apply_filters('the_content', $content);
            return $content;
        }

        return '';
    }

    public function renderComponent(Twig_Environment $env, $context, $componentName, $data = [], $withContext = true, $ignoreMissing = false, $sandboxed = false)
    {
        $data = $data === false ? [] : $data;
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
