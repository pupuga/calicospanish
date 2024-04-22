<?php

namespace Pupuga\Libs\Arrays;

class Transform
{
    public static function arrayToKeysValues($assocArray)
    {
        $array = array();

        foreach ($assocArray as $key => $value) {
            $array['keys'][] = $key;
            $array['values'][] = $value;
        }

        return $array;
    }
}
