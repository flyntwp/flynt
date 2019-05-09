<?php

namespace Flynt;

use ACFComposer\ACFComposer;
use Flynt\ComponentManager;
use Timber\Timber;
use Dflydev\DotAccessData\Data;

class Api
{
    public static function registerComponent($componentName, $componentPath = null)
    {
        $componentManager = ComponentManager::getInstance();
        $componentManager->registerComponent($componentName, $componentPath);
    }

    public static function registerComponentsFromPath($componentBasePath)
    {
        foreach (glob("{$componentBasePath}/*", GLOB_ONLYDIR) as $componentPath) {
            $componentName = basename($componentPath);
            self::registerComponent($componentName, $componentPath);
        }
    }

    public static function renderComponent($componentName, $data)
    {
        $data = apply_filters(
            'Flynt/addComponentData',
            $data,
            $componentName
        );
        $output = apply_filters(
            'Flynt/renderComponent',
            null,
            $componentName,
            $data
        );

        return is_null($output) ? '' : $output;
    }

    public static function registerFields($scope, $fields, $fieldsId = null)
    {
        global $flyntFields;
        $flyntFields = $flyntFields ?? [];
        if (empty($fieldsId)) {
            $flyntFields[$scope] = $fields;
        } else {
            $flyntFields[$scope] = $flyntFields[$scope] ?? [];
            $flyntFields[$scope][$fieldsId] = $fields;
        }
        return $fields;
    }

    public static function loadFields($scope, $fieldPath = null)
    {
        global $flyntFields;
        $flyntFields = $flyntFields ?? [];
        if (empty($fieldPath)) {
            return $flyntFields[$scope];
        } else {
            $data = new Data($flyntFields[$scope]);
            return $data->get($fieldPath);
        }
    }

    public static function registerHooks()
    {
        add_filter('Flynt/renderComponent', function ($output, $componentName, $data) {
            return apply_filters(
                "Flynt/renderComponent?name={$componentName}",
                $output,
                $componentName,
                $data
            );
        }, 10, 3);

        add_filter('Flynt/addComponentData', function ($data, $componentName) {
            return apply_filters(
                "Flynt/addComponentData?name={$componentName}",
                $data,
                $componentName
            );
        }, 10, 2);
    }

    public static function registerBlocks($layouts)
    {
        // create block and field group for block
        if (!function_exists('acf_register_block_type')) return null;

        foreach($layouts as $layout)
        {
            add_action('acf/init', function() use ($layout) {
                acf_register_block_type([
                    'name' => $layout['name'],
                    'title' => $layout['label'],
                    'description' => isset($layout['description']) ? $layout['description'] : null,
                    'category' => isset($layout['category']) ? $layout['category'] : 'formatting',
                    'icon' => isset($layout['icon']) ? $layout['icon'] : 'book-alt',
                    'keywords' => isset($layout['keywords']) ? $layout['keywords'] : [],
                    'align' => isset($layout['align']) ? $layout['align'] : 'full',
                    'supports' => [
                        'align' => false,
                        'mode' => true,
                        'multiple' => true,
                    ],
                    'render_callback' => function() use ($layout) {
                        $componentManager = ComponentManager::getInstance();
                        $componentName = ucfirst($layout['name']);
                        $templateFilename = apply_filters('Flynt/TimberLoader/templateFilename', 'index.twig');
                        $templateFilename = apply_filters("Flynt/TimberLoader/templateFilename?name=${componentName}", $templateFilename);
                        $filePath = $componentManager->getComponentFilePath($componentName, $templateFilename);
                        $relativeFilePath = ltrim(str_replace(get_template_directory(), '', $filePath), '/');

                        $fields = get_fields();
                        $data = apply_filters(
                            'Flynt/addComponentData',
                            $fields,
                            $componentName
                        );
                        Timber::render($relativeFilePath, $data);
                    }
                ]);

                $fieldGroupData = [
                    'name' => 'flynt_fields__' . strtolower($layout['name']),
                    'title' => 'Data',
                    'fields' => $layout['sub_fields'],
                    'location' => [
                        [
                            [
                                'param' => 'block',
                                'operator' => '==',
                                'value' => 'acf/' . strtolower($layout['name'])
                            ]
                        ]
                    ]
                ];

                ACFComposer::registerFieldGroup($fieldGroupData);
            });
        }
    }
}
