<?php

namespace Flynt\Utils;

class ScriptLoader
{
    /**
     * Adds async/defer attributes to enqueued / registered scripts.
     * Also adds type="module" and nomodule support.
     *
     * If #12009 lands in WordPress, this function can no-op since it would be handled in core.
     *
     * @link https://core.trac.wordpress.org/ticket/12009
     *
     * @param string $tag    The script tag.
     * @param string $handle The script handle.
     * @return string Script HTML string.
     */
    public function filterScriptLoaderTag($tag, $handle)
    {
        if (!empty(wp_scripts()->get_data($handle, 'type'))) {
            if (preg_match('/\stype="[^"]*"/', $tag, $match)) {
                $tag = str_replace($match[0], ' type="' . esc_attr(wp_scripts()->get_data($handle, 'type')) . '"', $tag);
            } else {
                $tag = str_replace('<script ', '<script type="' . esc_attr(wp_scripts()->get_data($handle, 'type')) . '" ', $tag);
            }
        }
        if (!empty(wp_scripts()->get_data($handle, 'nomodule'))) {
            if (preg_match('/snomodule([=\s]([\'\"])((?!\2).+?[^\\\])\2)?/', $tag, $match)) {
                $tag = str_replace($match[0], ' nomodule', $tag);
            } else {
                $tag = str_replace('<script ', '<script nomodule ', $tag);
            }
        }
        foreach (['async', 'defer'] as $attr) {
            if (!wp_scripts()->get_data($handle, $attr)) {
                continue;
            }
            // Prevent adding attribute when already added in #12009.
            if (!preg_match(":\s$attr(=|>|\s):", $tag)) {
                $tag = preg_replace(':(?=></script>):', " $attr", $tag, 1);
            }
            // Only allow async or defer, not both.
            break;
        }
        return $tag;
    }
}
