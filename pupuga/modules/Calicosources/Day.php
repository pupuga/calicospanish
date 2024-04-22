<?php

namespace Pupuga\Modules\Calicosources;

class Day
{
    protected $days;
    protected $wpdb;
    protected $data;

    public function __construct($objectDays)
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->days = $objectDays;
    }

    public function getData()
    {
        $this
            ->getSimpleData()
            ->getCustomData();

        return $this->data;
    }

    protected function getSimpleData()
    {
        $sql = 'SELECT p.* 
                FROM ' . $this->wpdb->posts . ' AS p
                WHERE p.ID IN (
                     SELECT tr.object_id
                     FROM ' . $this->wpdb->term_relationships . ' tr
                     WHERE tr.term_taxonomy_id = ' . $this->days->getDayId() . '	
                    )
                AND  p.ID IN (
                     SELECT tr.object_id
                     FROM ' . $this->wpdb->term_relationships . ' tr
                     WHERE tr.term_taxonomy_id = ' . $this->days->getLevelData()->term_id . '	
                    )
                AND p.post_status = "publish"
                ORDER BY p.post_date, p.menu_order';

        $this->data = $this->wpdb->get_results($sql);

        return $this;
    }

    protected function getCustomData()
    {
        if(count($this->data) > 0) {
            foreach ($this->data as $key => $post) {
                $this
                    ->setTermsData($key, $post)
                    ->setMetaData($key, $post);
            }
        }

        return $this;
    }

    protected function setTermsData($key, $post)
    {
        $terms = wp_get_post_terms($post->ID, 'type');
        $this->data[$key]->term_type = $terms[0]->slug;
        $this->data[$key]->termButtonLabel = carbon_get_term_meta( $terms[0]->term_id, 'sources_types_buttons_text' );

        return $this;
    }

    protected function setMetaData($key, $post)
    {
        $this->data[$key]->modules = carbon_get_post_meta($post->ID, 'modules');
        $this->data[$key]->buttonsHtml = (new ButtonsSource($post->ID, $this->data[$key]->termButtonLabel))->getButtons();

        return $this;
    }
}