<?php

namespace Flynt\AcfPerformance;

add_action('acf/init', function () {
    $types = acf()->fields->types;
    replaceLoadValue($types);
    if (defined('FLYNT_ACF_EXPERIMENTAL')) {
        replaceUpdateValue($types);
    }
});

function replaceLoadValue($types)
{
    replaceLoadValueGroupField($types['group']);
    replaceLoadValueRepeaterField($types['repeater']);
    replaceLoadValueFlexibleContentField($types['flexible_content']);
}

function replaceUpdateValue($types)
{
    replaceUpdateValueGroupField($types['group']);
    replaceUpdateValueRepeaterField($types['repeater']);
    replaceUpdateValueFlexibleContentField($types['flexible_content']);
}

function replaceLoadValueGroupField($groupField)
{
    remove_filter('acf/load_value/type=group', [$groupField, 'load_value'], 10);
    add_filter('acf/load_value/type=group', function ($value, $postId, $field) use ($groupField) {
        if (!empty($value) && is_string($value)) {
            return json_decode($value, true);
        } else {
            return $groupField->load_value($value, $postId, $field);
        }
    }, 10, 3);
}

function replaceUpdateValueGroupField($groupField)
{
    remove_filter('acf/update_value/type=group', [$groupField, 'update_value'], 10);
    add_filter('acf/update_value/type=group', function ($value, $postId, $field) use ($groupField) {
        if (!acf_is_array($value)) {
            return null;
        };
        // bail ealry if no sub fields
        if (empty($field['sub_fields'])) {
            return null;
        };

        $values = [];
        foreach ($field['sub_fields'] as $subField) {
            if (isset($value[$subField['key']])) {
                // key (backend)
                $values[$subField['key']] = $value[$subField['key']];
            } elseif (isset($value[$subField['_name']])) {
                // name (frontend)
                $values[$subField['key']] = $value[$subField['_name']];
            }
        }
        return json_encode($values);
    }, 10, 3);
}

function replaceLoadValueRepeaterField($repeaterField)
{
    remove_filter('acf/load_value/type=repeater', [$repeaterField, 'load_value'], 10);
    add_filter('acf/load_value/type=repeater', function ($value, $postId, $field) use ($repeaterField) {
        if (!empty($value) && is_string($value)) {
            $value = json_decode($value, true);
        }
        if (!is_array($value)) {
            return $repeaterField->load_value($value, $postId, $field);
        } else {
            return $value;
        }
    }, 10, 3);
}

function replaceUpdateValueRepeaterField($repeaterField)
{
    remove_filter('acf/update_value/type=repeater', [$repeaterField, 'update_value'], 10);
    add_filter('acf/update_value/type=repeater', function ($value, $postId, $field) use ($repeaterField) {
        // die();
        if (empty($field['sub_fields'])) {
            return $value;
        };
        $values = [];
        // update sub fields
        if (!empty($value)) {
            $i = -1;
            // remove acfcloneindex
            if (isset($value['acfcloneindex'])) {
                unset($value['acfcloneindex']);
            }
            // loop through rows
            foreach ($value as $row) {
                $i++;
                if (!is_array($row)) {
                    continue;
                }
                foreach ($field['sub_fields'] as $subField) {
                    if (isset($row[$subField['key']])) {
                        // find value (key)
                        $values[$i][$subField['key']] = $row[$subField['key']];
                    } elseif (isset($row[$subField['name']])) {
                        // find value (name)
                        $values[$i][$subField['key']] = $row[$subField['name']];
                    }
                }
            }
        }

        return json_encode($values);
    }, 10, 3);
}

function replaceLoadValueFlexibleContentField($flexibleContentField)
{
    remove_filter('acf/load_value/type=flexible_content', [$flexibleContentField, 'load_value'], 10);
    add_filter('acf/load_value/type=flexible_content', function ($value, $postId, $field) use ($flexibleContentField) {
        if (!empty($value) && is_string($value)) {
            return json_decode($value, true);
        } else {
            return $flexibleContentField->load_value($value, $postId, $field);
        }
    }, 10, 3);
}

function replaceUpdateValueFlexibleContentField($flexibleContentField)
{
    remove_filter('acf/update_value/type=flexible_content', [$flexibleContentField, 'update_value'], 10);
    add_filter('acf/update_value/type=flexible_content', function ($value, $postId, $field) use ($flexibleContentField) {
        if (empty($field['layouts'])) {
            return $value;
        }
        $values = [];
        if (!empty($value)) {
            $i = -1;
            // remove acfcloneindex
            if (isset($value['acfcloneindex'])) {
                unset($value['acfcloneindex']);
            }
            // loop through rows
            foreach ($value as $row) {
                $i++;
                // bail early if no layout reference
                if (!is_array($row) || !isset($row['acf_fc_layout'])) {
                    continue;
                }
                // get layout
                $layout = $flexibleContentField->get_layout($row['acf_fc_layout'], $field);
                // bail early if no layout
                if (!$layout || empty($layout['sub_fields'])) {
                    continue;
                }
                // loop
                $values[$i]['acf_fc_layout'] = $row['acf_fc_layout'];
                foreach ($layout['sub_fields'] as $subField) {
                    if (isset($row[$subField['key']])) {
                        // find value (key)
                        $values[$i][$subField['key']] = $row[$subField['key']];
                    } elseif (isset($row[$subField['name']])) {
                        // find value (name)
                        $values[$i][$subField['key']] = $row[$subField['name']];
                    }
                }
            }
        }
        return json_encode($values);
    }, 10, 3);
}
