<?php

namespace Flynt\Utils;

class ColorHelpers
{
    /**
     * Converts a color from hex to rgba.
     *
     * @since 2.0
     *
     * @param string $color The color to convert.
     * @param int $opacity The color opacity.
     * @param string $returnType The return format, string or array.
     *
     * @return mixed
     */
    public static function hexToRgba($color, $opacity = 1, $returnType = 'array')
    {
        $color = str_replace('#', '', $color);

        if (strlen($color) === 3) {
            $r = hexdec(substr($color, 0, 1) . substr($color, 0, 1));
            $g = hexdec(substr($color, 1, 1) . substr($color, 1, 1));
            $b = hexdec(substr($color, 2, 1) . substr($color, 2, 1));
        } else {
            $r = hexdec(substr($color, 0, 2));
            $g = hexdec(substr($color, 2, 2));
            $b = hexdec(substr($color, 4, 2));
        }

        $rgba = [ $r, $g, $b, $opacity ];

        if ($returnType === 'string') {
            return 'rgba(' . implode(',', $rgba) . ')';
        }

        return $rgba;
    }

    /**
     * Converts a color from rgba to hsla.
     *
     * @since 2.0
     *
     * @param string $color The color to convert.
     * @param int $opacity The color opacity.
     * @param string $returnType The return format, string or array.
     *
     * @return mixed
     */
    public static function rgbaToHsla($color, $opacity = 1, $returnType = 'array')
    {
        $r = $color[0] / 255;
        $g = $color[1] / 255;
        $b = $color[2] / 255;

        $min = min($r, min($g, $b));
        $max = max($r, max($g, $b));
        $delta = $max - $min;

        $h = 0;
        $s = 0;
        $l = 0;

        if ($delta > 0) {
            if ($max === $r) {
                $h = (($g - $b) / $delta) % 6;
            } else if ($max === $g) {
                $h = ($b - $r) / $delta + 2;
            } else {
                $h = ($r - $g) / $delta + 4;
            }
        }

        $h = round($h * 60);

        if ($h < 0) {
            $h += 360;
        }

        $l = ($min + $max) / 2;
        $s = $delta == 0 ? 0 : $delta / (1 - abs(2 * $l - 1));

        $s = round($s * 100, 1);
        $l = round($l * 100, 1);

        $hsla = [ $h, "$s%", "$l%", $opacity ];

        if ($returnType === 'string') {
            return 'hsla(' . implode(',', $hsla) . ')';
        }

        return $hsla;
    }

    /**
     * Converts a color from hex to hsla.
     *
     * @since 2.0
     *
     * @param string $color The color to convert.
     * @param int $opacity The color opacity.
     * @param string $returnType The return format, string or array.
     *
     * @return mixed
     */
    public static function hexToHsla($color, $opacity = 1, $returnType = 'array')
    {
        $rgba = self::hexToRgba($color, $opacity);
        return self::rgbaToHsla($rgba, $opacity, $returnType);
    }
}
