<?php

namespace Pupuga;

Class Help
{
    /**
     * pre print
     * @param array $args
     */
    public static function print_r($args)
    {
        print '<pre>';
        print_r($args);
        print '</pre>';
    }
}