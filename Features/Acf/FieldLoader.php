<?php

namespace Flynt\Features\Acf;

use Flynt\Utils\ArrayHelpers;
use Flynt\Utils\StringHelpers;
use Flynt\ComponentManager;

class FieldLoader
{
    const FILTER_NAMESPACES = [
        'component' => 'Flynt/Components',
        'customPostType' => 'Flynt/CustomPostTypes',
        'feature' => 'Flynt/Features'
    ];

    public static function setup()
    {
        add_action(
            'Flynt/registerComponent',
            ['Flynt\Features\Acf\FieldLoader', 'loadComponentFields'],
            11
        );

        add_action(
            'Flynt/Features/CustomPostTypes/Register',
            ['Flynt\Features\Acf\FieldLoader', 'loadCustomPostTypeFields'],
            10,
            2
        );

        add_action(
            'Flynt/registerFeature',
            ['Flynt\Features\Acf\FieldLoader', 'loadFeatureFields'],
            10,
            3
        );
    }

    public static function loadComponentFields($name)
    {
        // load fields.json if it exists
        $componentManager = ComponentManager::getInstance();
        $filePath = $componentManager->getComponentFilePath($name, 'fields.json');

        // make sure naming convention is kept
        $name = ucfirst($name);

        // add filters
        self::addFilters('component', $name, $filePath);
    }

    public static function loadCustomPostTypeFields($name, $customPostType)
    {
        $filePath = $customPostType['dir'] . '/fields.json';

        $name = StringHelpers::kebapCaseToCamelCase($name);

        self::addFilters('customPostType', $name, $filePath);
    }

    public static function loadFeatureFields($name, $options, $dir)
    {
        $filePath = $dir . '/fields.json';

        self::addFilters('feature', $name, $filePath);
    }

    public static function addFilters($category, $name, $filePath)
    {
        if (false === $filePath || !file_exists($filePath)) {
            return;
        }

        $fields = json_decode(file_get_contents($filePath), true);

        foreach ($fields as $groupKey => $groupValue) {
            $groupKey = ucfirst($groupKey);
            $filterNamespace = self::FILTER_NAMESPACES[$category];
            $filterName = "{$filterNamespace}/{$name}/Fields/{$groupKey}";

            add_filter($filterName, function ($config) use ($groupValue) {
                return $groupValue;
            });
            if (ArrayHelpers::isAssoc($groupValue) && array_key_exists('sub_fields', $groupValue)) {
                $filterName .= '/SubFields';
                $subFields = $groupValue['sub_fields'];

                add_filter($filterName, function ($subFieldsconfig) use ($subFields) {
                    return $subFields;
                });

                self::addFilterForSubFields($filterName, $subFields);
            } elseif (is_array($groupValue)) {
                self::addFilterForSubFields($filterName, $groupValue);
            }
        }
    }

    protected static function addFilterForSubFields($parentFilterName, $subFields)
    {
        foreach ($subFields as $subField) {
            if (is_string($subField)) {
                continue;
            }
            if (!array_key_exists('name', $subField)) {
                trigger_error('[ACF] Name is missing in Sub Field while adding Filter: ' . $parentFilterName, E_USER_WARNING);
                continue;
            }
            $subFieldName = ucfirst($subField['name']);
            $subFilterName =  "{$parentFilterName}/{$subFieldName}";

            add_filter($subFilterName, function ($subFieldConfig) use ($subField) {
                return $subField;
            });
        }
    }
}
