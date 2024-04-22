<?php

namespace Pupuga\Modules\Blog;

class Taxonomies
{
    public static function getCategories($id, $filter = array('fields' => 'all'))
    {
        $items = wp_get_post_categories($id, $filter);
        $html = self::loopTemplate($items);

        return $html;
    }

    public static function getTags($id)
    {
        $items = get_the_tags($id);
        $html = self::loopTemplate($items);

        return $html;
    }

    public static function loopTemplate($items)
    {
        $html = '';
        if (!is_null($items) && !empty($items) && count($items) > 0) {
            foreach ($items as $item) {
                $html .= '<li class="pupuga-items__item"><a href="' . get_term_link($item->term_id) . '">' . $item->name . '</a></li>';
            }

            if (!empty($html)) {
                $html = '<ul class="pupuga-items">' . $html . '</ul>';
            }

        }

        return $html;
    }
}