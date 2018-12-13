<?php

namespace Flynt;

class Render
{
    public static function fromConstructionPlan($constructionPlan)
    {
        if (false === self::validateConstructionPlan($constructionPlan)) {
            return '';
        }

        $areaHtml = self::extractAreaHtml($constructionPlan);

        return self::applyRenderFilters($constructionPlan, $areaHtml);
    }

    protected static function validateConstructionPlan($constructionPlan)
    {
        return self::validateConstructionPlanIsNonEmptyArray($constructionPlan)
        && self::validateConstructionPlanName($constructionPlan)
        && self::validateConstructionPlanData($constructionPlan);
    }

    protected static function validateConstructionPlanIsNonEmptyArray($constructionPlan)
    {
        if (!is_array($constructionPlan)) {
            trigger_error(
                'Construction Plan is not an array! ' . ucfirst(gettype($constructionPlan)) . ' given.',
                E_USER_WARNING
            );
            return false;
        } elseif (empty($constructionPlan)) {
            trigger_error('Empty Construction Plan array!', E_USER_WARNING);
            return false;
        } else {
            return true;
        }
    }

    protected static function validateConstructionPlanName($constructionPlan)
    {
        if (!isset($constructionPlan['name'])) {
            trigger_error('Construction Plan is missing key: "name"', E_USER_WARNING);
            return false;
        } elseif (!is_string($constructionPlan['name'])) {
            trigger_error('Construction Plan key "name" is not a string!', E_USER_WARNING);
            return false;
        } else {
            return true;
        }
    }

    protected static function validateConstructionPlanData($constructionPlan)
    {
        if (!isset($constructionPlan['data'])) {
            trigger_error('Construction Plan is missing key: "data"', E_USER_WARNING);
            return false;
        } elseif (!is_array($constructionPlan['data'])) {
            trigger_error('Construction Plan key "data" is not an array!', E_USER_WARNING);
            return false;
        } else {
            return true;
        }
    }

    protected static function extractAreaHtml($constructionPlan)
    {
        $areaHtml = [];
        if (array_key_exists('areas', $constructionPlan)) {
            if (!is_array($constructionPlan['areas'])) {
                trigger_error('Construction Plan key "areas" is not an array!', E_USER_WARNING);
            } else {
                $areas = $constructionPlan['areas'];
                $areaHtml = array_reduce(
                    array_keys($areas),
                    function ($carry, $areaName) use ($areas) {
                        $carry[$areaName] = self::joinAreaComponents($areaName, $areas);
                        return $carry;
                    },
                    []
                );
            }
        }
        return $areaHtml;
    }

    protected static function joinAreaComponents($areaName, $areas)
    {
        $components = $areas[$areaName];

        // "areas" need to be an associative array
        if (is_int($areaName)) {
            trigger_error('Area name is not defined!', E_USER_WARNING);
            return '';
        }
        if (!is_array($components)) {
            trigger_error("Area \"{$areaName}\" is not an array!", E_USER_WARNING);
            return '';
        }
        return implode('', array_map('self::fromConstructionPlan', $components));
    }

    protected static function applyRenderFilters($constructionPlan, $areaHtml)
    {
        $componentData = $constructionPlan['data'];
        $componentName = $constructionPlan['name'];

        $output = apply_filters('Flynt/renderComponent', null, $componentName, $componentData, $areaHtml);
        $output = apply_filters(
            "Flynt/renderComponent?name={$componentName}",
            $output,
            $componentName,
            $componentData,
            $areaHtml
        );

        return is_null($output) ? '' : $output;
    }
}
