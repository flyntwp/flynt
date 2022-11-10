<?php

namespace Flynt\Utils;

class ScriptAndStyleLoader
{
    /**
     * Adds async/defer attributes to enqueued / registered scripts or add a preload link.
     *
     * @param string $tag The script tag.
     * @param string $handle The script handle.
     * @param string $src The script src.
     * @return string Script HTML string.
     */
    public function filterScriptLoaderTag($tag, $handle, $src)
    {
        /**
        * If #12009 lands in WordPress, this loop can no-op since it would be handled in core.
        *
        * @link https://core.trac.wordpress.org/ticket/12009
        */
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

        foreach (['preload'] as $attr) {
            if (!wp_scripts()->get_data($handle, $attr)) {
                continue;
            }

            if (!preg_match(":\s$attr(=|>|\s):", $tag)) {
                $tag = $this->addPreloadLinkBeforeTag($tag, $src, 'script');
            }

            break;
        }
        if (wp_scripts()->get_data($handle, 'module')) {
            $tag = preg_replace(':(?=></script>):', " type=\"module\"", $tag, 1);
        }
        return $tag;
    }

    /**
     * Add a preload link.
     *
     * @param string $tag The style tag.
     * @param string $handle The style handle.
     * @param string $src The style src.
     * @return string Style HTML string.
     */
    public function filterStyleLoaderTag($tag, $handle, $src)
    {
        foreach (['preload'] as $attr) {
            if (!wp_styles()->get_data($handle, $attr)) {
                continue;
            }

            if (!preg_match(":\s$attr(=|>|\s):", $tag)) {
                $tag = $this->addPreloadLinkBeforeTag($tag, $src, 'style');
            }

            break;
        }
        return $tag;
    }

    /**
     * Add a preload link right before a tag.
     *
     * @param string $tag HTML tag.
     * @param string $src src attribute value.
     * @param string $type type script|style.
     * @return string HTML string.
     */
    private function addPreloadLinkBeforeTag($tag, $src, $type)
    {
        $tag = '<link rel="preload" href="' . $src . '" as="' . $type . '">' . $tag;
        return $tag;
    }
}
