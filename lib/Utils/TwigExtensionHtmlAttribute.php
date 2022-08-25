<?php

namespace Flynt\Utils;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigExtensionHtmlAttribute extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('addAttribute', [$this, 'renderHtmlAttributes']),
        ];
    }

    /**
     *  Prepare and render HTML attribute string.
     *
     * @param string $attribute
     * @param string $value
     * @param string $prefix
     * @return mixed
     */
    public function renderHtmlAttributes($attribute = '', $value = '', string $prefix = 'data-')
    {
        if (empty($attribute)) {
            return '';
        }

        $prefix = sanitize_title($prefix);
        if (!StringHelpers::endsWith($prefix, '-')) {
            $prefix = $prefix . '-';
        }

        if (is_array($attribute)) {
            $output = '';
            foreach ($attribute as $key => $value) {
                $attribute = $prefix . $key;
                $output .= $this->createAttributeData($attribute, strval($value));
            }
            return $output;
        } else {
            $attribute = $prefix . $attribute;
            return $this->createAttributeData($attribute, $value);
        }
    }

    /**
     *  Build the HTML attribute string.
     *
     * @param string $attribute
     * @param string $value
     * @return string
     */
    private function createAttributeData(string $attribute = '', $value = '')
    {
        if (empty($attribute) || empty($value)) {
            return '';
        }

        $attribute = StringHelpers::camelCaseToKebap($attribute);
        $attribute = sanitize_title($attribute);
        $value = esc_attr($value);

        return sprintf('%s="%s"', $attribute, $value);
    }
}
