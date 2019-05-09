<?php

namespace Flynt;

use ACFComposer\ACFComposer;
use Flynt\ComponentManager;
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

    }
}
