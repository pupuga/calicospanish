<?php

namespace Pupuga\Modules\Calicosources;

class FilterGridAdminTable extends \Pupuga\Core\Posts\FilterGridAdminTableCreate
{

    public function __construct()
    {
        parent::__construct();
        if ($_GET['post_type'] == 'sources') {
            $this->addedClauses();
        }
    }

    private function addedClauses()
    {
        global $wpdb;
        $clauses = ['join' => '', 'where' => '', 'orderby' => ''];

        if(isset($_GET['lessons']) && !empty($_GET['lessons'])) {
            $lessonId = intval(trim($_GET['lessons']));
            $clauses['join'] .= ' LEFT JOIN ' . $wpdb->term_relationships . ' AS r_lessons ON r_lessons.object_id = ' . $wpdb->posts . '.ID ';
            $clauses['where'] .= 'AND r_lessons.term_taxonomy_id = ' . $lessonId;
        }

        if(isset($_GET['days']) && !empty($_GET['days'])) {
            $dayId = intval(trim($_GET['days']));
            if (isset($_GET['lessons']) && !empty($_GET['lessons'])) {
                $clauses['where'] .= ' AND ' . $wpdb->posts . '.ID IN (SELECT r_days.object_id FROM ' . $wpdb->term_relationships . ' r_days WHERE r_days.term_taxonomy_id = ' . $dayId . ')';
                $clauses['orderby'] .= 'wp_posts.menu_order ASC, wp_posts.post_date ASC, wp_posts.post_title ASC';
            } else {
                $clauses['join'] .= ' LEFT JOIN ' . $wpdb->term_relationships . ' AS r_days ON r_days.object_id = ' . $wpdb->posts . '.ID ';
                $clauses['where'] .= 'AND r_days.term_taxonomy_id = ' . $dayId;
            }
        }

        $this->setCustomAction($clauses);
    }

    public function setCustomAction($clauses)
    {
        $this
            ->setJoin($clauses['join'])
            ->setWhere($clauses['where'])
            ->setOrderby($clauses['orderby'], true)
            ->action();
    }
}