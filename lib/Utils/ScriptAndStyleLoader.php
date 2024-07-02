<?php

namespace Flynt\Utils;

/**
 * Provides functions to modify the script and style loader.
 */
class ScriptAndStyleLoader
{
    /**
     * Filters the script loader tag.
     *
     * @param string $tag The script tag.
     * @param string $handle The script handle.
     * @param string $src The script src.
     * @return string Script HTML string.
     */
    public function filterScriptLoaderTag(string $tag, string $handle, string $src)
    {
        if (wp_scripts()->get_data($handle, 'module')) {
            return preg_replace(':(?=></script>):', ' type="module"', $tag, 1);
        }

        return $tag;
    }
}
