<?php

namespace Pupuga\Modules\Sitemap;

final class DataTaxonomies
{
    private static $instance;
    private $wpdb;
    private $taxonomies;
    private $ids = array();

    private function __construct($taxonomies)
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->taxonomies = $taxonomies;
        $this->ids = $this->setIds();
    }

    /**
     * @return $this
     */
    public static function app(array $taxonomies)
    {
        if (self::$instance == null) {
            self::$instance = new self($taxonomies);
        }

        return self::$instance;
    }

    private function setSql()
    {
        $taxonomies = '"' . implode('","', $this->taxonomies) . '"';
        $sql =
            'SELECT ' . $this->wpdb->posts . '.id
            FROM ' . $this->wpdb->posts . ' 
            JOIN ' . $this->wpdb->term_relationships . ' ON wp_posts.ID = wp_term_relationships.object_id
            JOIN ' . $this->wpdb->terms . ' ON ' . $this->wpdb->term_relationships . '.term_taxonomy_id = ' . $this->wpdb->terms . '.term_id
            AND ' . $this->wpdb->posts . '.post_type = "product" 
            AND ' . $this->wpdb->terms . '.slug IN (' . $taxonomies . ')
            GROUP BY ' . $this->wpdb->posts . '.id';

        return $sql;
    }

    private function setIds()
    {
        $objects = $this->wpdb->get_results($this->setSql());
        $ids = array_column($objects, 'id');
        $ids = array_combine($ids, $ids);

        return $ids;
    }

    public function getIds()
    {
        return $this->ids;
    }
}