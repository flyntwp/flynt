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
        if (is_array($value)) {
            $rawGroupValues = $value;
        } elseif (!empty($value) && is_string($value)) {
            $rawGroupValues = json_decode($value, true);
        } else {
            return $groupField->load_value($value, $postId, $field);
        }
        $groupValues = [];
        foreach ($field['sub_fields'] as $subField) {
            $key = $subField['key'];
            $groupValues[$key] = loadValue($rawGroupValues[$key] ?? null, $postId, $subField);
        }
        return $groupValues;
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
                $subFieldValue = $value[$subField['key']];
                $values[$subField['key']] = updateValue($subFieldValue, $postId, $subField);
            } elseif (isset($value[$subField['_name']])) {
                // name (frontend)
                $subFieldValue = $value[$subField['_name']];
                $values[$subField['key']] = updateValue($subFieldValue, $postId, $subField);
            }
        }

        if ($field['jsonUpdate'] ?? null) {
            return $values;
        } else {
            return safeJsonEncode($values);
        }
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
        }
        $repeaterValues = [];
        $i = -1;
        foreach ($value as $row) {
            $i++;
            if (!is_array($row)) {
                continue;
            }
            foreach ($field['sub_fields'] as $subField) {
                $key = $subField['key'];
                $repeaterValues[$i][$key] = loadValue($row[$key] ?? null, $postId, $subField);
            }
        }
        return $repeaterValues;
    }, 10, 3);
}

function replaceUpdateValueRepeaterField($repeaterField)
{
    remove_filter('acf/update_value/type=repeater', [$repeaterField, 'update_value'], 10);
    add_filter('acf/update_value/type=repeater', function ($value, $postId, $field) use ($repeaterField) {
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
                        $subFieldValue = $row[$subField['key']];
                        $values[$i][$subField['key']] = updateValue($subFieldValue, $postId, $subField);
                    } elseif (isset($row[$subField['name']])) {
                        // find value (name)
                        $subFieldValue = $row[$subField['name']];
                        $values[$i][$subField['key']] = updateValue($subFieldValue, $postId, $subField);
                    }
                }
            }
        }

        if ($field['jsonUpdate'] ?? null) {
            return $values;
        } else {
            return safeJsonEncode($values);
        }
    }, 10, 3);
}

function replaceLoadValueFlexibleContentField($flexibleContentField)
{
    remove_filter('acf/load_value/type=flexible_content', [$flexibleContentField, 'load_value'], 10);
    add_filter('acf/load_value/type=flexible_content', function ($value, $postId, $field) use ($flexibleContentField) {
        if (!empty($value) && is_string($value)) {
            $rawFlexibleContentValues = json_decode($value, true);
        } elseif (is_array($value) && isset($value[0]['acf_fc_layout'])) {
            $rawFlexibleContentValues = $value;
        } else {
            return $flexibleContentField->load_value($value, $postId, $field);
        }
        $flexibleContentValues = [];
        $i = -1;
        foreach ($rawFlexibleContentValues as $row) {
            $i++;
            if (!is_array($row) || !isset($row['acf_fc_layout'])) {
                continue;
            }
            $layout = $flexibleContentField->get_layout($row['acf_fc_layout'], $field);
            if (!$layout || empty($layout['sub_fields'])) {
                continue;
            }
            $flexibleContentValues[$i]['acf_fc_layout'] = $row['acf_fc_layout'];
            foreach ($layout['sub_fields'] as $subField) {
                $key = $subField['key'];
                $flexibleContentValues[$i][$key] = loadValue($row[$key], $postId, $subField);
            }
        }
        return $flexibleContentValues;
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
                        $subFieldValue = $row[$subField['key']];
                        $values[$i][$subField['key']] = updateValue($subFieldValue, $postId, $subField);
                    } elseif (isset($row[$subField['name']])) {
                        // find value (name)
                        $subFieldValue = $row[$subField['name']];
                        $values[$i][$subField['key']] = updateValue($subFieldValue, $postId, $subField);
                    }
                }
            }
        }
        if ($field['jsonUpdate'] ?? null) {
            return $values;
        } else {
            return safeJsonEncode($values);
        }
    }, 10, 3);
}

function loadValue($value, $postId, $field)
{
    // Use field's default_value if no meta was found.
    if ($value === null && isset($field['default_value'])) {
        $value = $field['default_value'];
    }
    // Filters the $value after it has been loaded.
    $value = apply_filters("acf/load_value", $value, $postId, $field);
    return $value;
}

function updateValue($value, $postId, $field)
{
    $field['jsonUpdate'] = true;
    $value = apply_filters("acf/update_value", $value, $postId, $field, $value);
    return $value;
}

function safeJsonEncode($obj)
{
    $json = json_encode($obj, JSON_HEX_APOS | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_LINE_TERMINATORS);
    return strtr($json, [
        '\n' => '\\\\n',
        '\r' => '\\\\r',
        '\t' => '\\\\t',
        '\f' => '\\\\f',
        '\d' => '\\\\d',
    ]);
}
