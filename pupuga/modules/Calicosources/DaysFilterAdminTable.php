<?php

namespace Pupuga\Modules\Calicosources;

class DaysFilterAdminTable extends \Pupuga\Core\Posts\FilterAdminTableCreate
{
    protected function setData()
    {
        $terms = get_terms(array(
            'taxonomy' => 'day',
            'orderby' => 'slug',
            'hide_empty' => true,
        ));
        foreach ($terms as $term) {
            $this->data[$term->term_id] = $term->name;
        }
    }
}