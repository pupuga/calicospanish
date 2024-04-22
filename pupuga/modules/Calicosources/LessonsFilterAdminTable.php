<?php

namespace Pupuga\Modules\Calicosources;

class LessonsFilterAdminTable extends \Pupuga\Core\Posts\FilterAdminTableCreate
{
    protected function setData()
    {
        $terms = get_terms(array(
            'taxonomy' => 'level',
            'orderby' => 'slug',
            'hide_empty' => false,
            'childless' => true
        ));
        foreach ($terms as $term) {
            $this->data[$term->term_id] = $term->name;
        }
    }
}