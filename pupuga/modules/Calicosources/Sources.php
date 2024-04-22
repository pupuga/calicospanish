<?php

namespace Pupuga\Modules\Calicosources;

abstract class Sources
{
    protected $wpdb;
    protected $atts;
    protected $slug;
    protected $data;
    protected $levelData;

    protected $breadcrumb = [
        [
            'name' => 'YOU ARE HERE'
        ],
        [
            'name' => 'Stories Online',
            'link' => 'get-started'
        ]
    ];

    abstract protected function setCurrentBreadcrumb();

    abstract protected function setSlug();

    public function __construct($atts)
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->atts = $atts;
    }

    protected function setLevelData()
    {
        $this->levelData = $this->getTaxonomyData($this->slug, 'slug');
    }

    public function getLoopData()
    {
        return $this->data;
    }

    public function getBreadcrumb()
    {
        return $this->breadcrumb;
    }

    public function getLevelData()
    {
        return $this->levelData;
    }

    protected function getTaxonomyData($value, $field = 'id')
    {
        $levelData = get_term_by($field, $value, 'level');
        $fields = ['title', 'title_plus', 'objectives', 'need', 'access'];
        if (count($fields)) {
            foreach ($fields as $key => $name) {
                $field = $name;
                $levelData->$field = carbon_get_term_meta($levelData->term_id, 'sources_levels_' . $name);
            }
        }

        return $levelData;
    }
}