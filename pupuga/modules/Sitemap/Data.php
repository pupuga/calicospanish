<?php

namespace Pupuga\Modules\Sitemap;

final class Data
{
    private $content = array(
        'title' => 'Sitemap'
    );
    private $types = array('post', 'page', 'product');
    private $taxonomiesExclude = array('plans', 'calicospanish-plans');
    /*
     * keys => name, dbName, linkAdmin, link, form, default
     */
    private $columns = array(
        'check' => array(
            'name' => 'Check'
        ),
        'no' => array(
            'name' => 'No'
        ),
        'id' => array(
            'name' => 'Id',
            'dbName' => 'id',
            'linkAdmin' => 1
        ),
        'type' => array(
            'name' => 'Type',
            'dbName' => 'post_type as type'
        ),
        'date' => array(
            'name' => 'Date',
            'dbName' => 'DATE_FORMAT(post_date, "%Y-%m-%d") as date'
        ),
        'title' => array(
            'name' => 'Title',
            'dbName' => 'post_title as title',
            'link' => 1
        ),
        'period' => array(
            'name' => 'Period',
            'form' => 'select',
            'choice' => array('always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly'),
            'default' => 'daily'
        ),
        'priority' => array(
            'name' => 'Priority',
            'form' => 'number',
            'step' => 0.1,
            'default' => 0.9,
        )
    );
    private static $instance;
    private $list;
    private $options;
    private $sql;
    private $wpdb;

    private function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;

        $this->setOptions();
        $this->setList();
    }

    /**
     * @return $this
     */
    public static function app()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function getTypes()
    {
        return $this->types;
    }

    public function getList()
    {
        return $this->list;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setTypes(array $typesExclude)
    {
        $this->types = $this->wpdb->get_results($this->setTypesSql($typesExclude));

        return $this;
    }

    private function setList()
    {
        $this->list = $this->wpdb->get_results($this->setListSql());

        return $this;
    }


    private function setOptions()
    {
        $this->options = get_option('pupuga_sitemap');

        return $this;
    }

    private function setTypesSql(array $typesExclude)
    {
        $typesExclude = '"' . implode('","', $typesExclude) . '"';
        $this->sql = sprintf(
            "SELECT p.post_type
             FROM wp_posts p 
             WHERE p.post_status = 'publish'
             AND p.post_type NOT IN (%s)
             GROUP BY p.post_type
             ORDER BY p.post_type", $typesExclude);

        return $this->sql;
    }

    private function setListSql()
    {
        $typesString = '"' . implode('","', $this->types) . '"';
        $idsString = '"' . implode('","', DataSecure::app()->getIds() + DataTaxonomies::app($this->taxonomiesExclude)->getIds()) . '"';
        $fieldsString = implode(',', array_column($this->columns, 'dbName'));

        $this->sql = sprintf(
            "SELECT %s 
             FROM wp_posts 
             WHERE post_type IN (%s)
             AND id NOT IN (%s)
             AND post_status = 'publish'
             ORDER BY type, title, id", $fieldsString, $typesString, $idsString);

        return $this->sql;
    }
}