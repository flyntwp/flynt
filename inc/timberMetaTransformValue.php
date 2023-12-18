<?php

/**
 * Transform meta values to Timber/standard PHP objects.
 * see: https://timber.github.io/docs/v2/hooks/filters/#timber/meta/transform_value
 */

namespace Flynt\TimberMetaTransformValue;

add_filter('timber/meta/transform_value', '__return_true');
