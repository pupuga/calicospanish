<?php

namespace Pupuga\Libs\Data;

class Url
{
    /**
     * @param string $part can be host|query|path
     * @param null|string $url
     * @return mixed
     */
    public static function parseUrl($part, $url = null)
    {
        $url = $url ?: $_SERVER['REQUEST_URI'];
        $parse = parse_url($url);
        switch ($part) {
            case 'host':
                $result = $parse['path'];
                break;
            case 'query':
                parse_str($parse['query'], $result);
                break;
            case 'path':
                $result = trim($parse['path'], '/');
                $result = explode('/', $result);
                break;
            default:
                $result = $parse;
        }

        return $result;
    }

    /**
     * @param null|string $url
     * @return array
     */
    public static function getHost($url = null)
    {
        return self::parseUrl('host', $url);
    }

    /**
     * @param null|string $url
     * @return array
     */
    public static function getQuery($url = null)
    {
        return self::parseUrl('query', $url);
    }

    /**
     * @param null|string $url
     * @return array
     */
    public static function getPath($url = null)
    {
        return self::parseUrl('path', $url);
    }

}