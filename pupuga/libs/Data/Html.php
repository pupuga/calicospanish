<?php

namespace Pupuga\Libs\Data;

use Pupuga\Libs\Arrays\Transform;

class Html
{
    /**
     * replacing search Key to replace Value in custom html
     *
     * @return string $html
     */
    public static function replaceTemplateInHtml($html, $searchReplace = array())
    {
        if (trim($html) && is_array($searchReplace) && count($searchReplace) > 0) {
            $keysValues = Transform::arrayToKeysValues($searchReplace);
            $search = $keysValues['keys'];
            $replace = $keysValues['value'];
            $html = str_replace($search, $replace, $html);
        }

        return $html;
    }

    /**
     * replacing '[' => '<', ']' => '>' in custom html
     *
     * @param string $html
     *
     * @return string $html
     */
    public static function replaceBracketsInHtml($html)
    {
        $replaceData = array(
            '[' => '<',
            ']' => '>',
        );
        self::replaceTemplateInHtml($html, $replaceData);

        return $html;
    }

    /**
     * clean empty p tags in html
     *
     * @param string $html
     *
     * @return string $html
     */
    public static function cleanEmptyTagsHtml($html)
    {
        $html = preg_replace(array('/\<p\>([ \t\n\r\f\v]*)\<div/', '/\<\/div\>([ \t\n\r\f\v]*)\<\/p\>/'), array('<div', '</div>'), $html);
        $html = preg_replace(array('/\<\/p\>([ \t\n\r\f\v]*)\<\/p\>/'), array(''), $html);

        return $html;
    }

    /**
     * clean & do shortcode
     *
     * @param string $html
     *
     * @return string $html
     */
    public static function transformHtml($html)
    {
        $html = self::cleanEmptyTagsHtml(do_shortcode(wpautop($html)));

        return $html;
    }

}