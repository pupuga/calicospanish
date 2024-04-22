<?php

namespace Pupuga\Core\Carbon;

class Helper
{
    private function __construct()
    {
    }

    public static function hook($object, $method = 'registerCarbonFields')
    {
        add_action('carbon_fields_register_fields', array($object, $method));
    }

    public static function getPostMeta($id, Array $metas)
    {
        $results = new \stdClass();
        if (is_array($metas) && count($metas) > 0) {
            foreach ($metas as $meta) {
                $results->$meta = carbon_get_post_meta($id, $meta);
            }
        }

        return $results;
    }
}