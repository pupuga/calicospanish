<?php

namespace Pupuga\Modules\Calicosources;

class ResourcesSql
{

    private static $instance;
    protected $wpdb;
    protected $sql = '';
    protected $sqlSelect = '';
    protected $sqlGroup = '';
    protected $params;
    protected $type;
    protected $level;
    protected $filter;

    private function __construct($params)
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->params = $params;
        $this->setType()
            ->setLevel()
            ->setFilter()
            ->setSql();
    }

    public static function app($params)
    {
        if (self::$instance == null) {
            self::$instance = new self($params);
        }

        return self::$instance;
    }

    protected function setType()
    {
        $this->type = $this->params['type'];

        return $this;
    }

    protected function setLevel()
    {
        $this->level = ($this->params['level'] == 'all-levels') ? 'level' : $this->params['level'];

        return $this;
    }

    protected function setFilter()
    {
        $method = 'setFilter' . ucfirst($this->params['filter']);
        if (method_exists($this, $method) && $method != 'setFilter') {
            $this->$method();
            if (!empty($this->sqlSelect)) {
                $this->sqlSelect = ', ' . $this->sqlSelect;
            }
        }

        return $this;
    }

    protected function setFilterModule()
    {
        $this->filter = "AND pm.meta_key LIKE '%modules|{$this->params['filter_value']}%'";
        switch($this->params['filter_value']){
            case 'video_hosting_url':
            case 'source_audio':
                $fieldName = 'meta_value';
                $this->sqlSelect = "TRIM(TRAILING '/' FROM pm.meta_value) {$fieldName}";
                $this->sqlGroup = "GROUP BY {$fieldName}";
                break;
            case 'source_media':
                $this->sqlSelect = "GROUP_CONCAT(pm.meta_value) images_ids, GROUP_CONCAT(pm.meta_key) images_order";
                $this->sqlGroup = "GROUP BY pm.post_id";
                break;
        }
    }

    protected function setFilterFile()
    {
        $this->sqlSelect = "pm.meta_value";
        $this->filter = "AND pm.meta_key LIKE '%{$this->params['filter_value']}%'";
        switch ($this->type) {
            case 'games':
                $this->filter = "AND ((pm.meta_key LIKE '%{$this->params['filter_value']}%' AND pm.meta_value <> '') OR pm.meta_value = 'play')";
               break;
            default :
                $this->filter = "AND pm.meta_key LIKE '%{$this->params['filter_value']}%'";
        }
        $this->sqlGroup = "GROUP BY pm.meta_value";
    }

    protected function setSql()
    {
        $this->sql = "SELECT MIN(tr.object_id) object_id, t.term_id, t.name, t.slug {$this->sqlSelect} FROM {$this->wpdb->term_relationships} tr
                      INNER JOIN {$this->wpdb->terms} t ON t.term_id = tr.term_taxonomy_id
                      INNER JOIN {$this->wpdb->postmeta} pm ON pm.post_id = tr.object_id
                      WHERE tr.object_id IN (
                            SELECT trl.object_id FROM {$this->wpdb->term_relationships} trl
                            INNER JOIN {$this->wpdb->terms} tl ON tl.term_id = trl.term_taxonomy_id
                            AND tl.slug = '{$this->type}'
                      )
                      AND t.slug LIKE '%{$this->level}-%'
                      {$this->filter}
                      {$this->sqlGroup}
                      ORDER BY t.slug";

        return $this;
    }


    public function getSql()
    {
        return $this->sql;
    }

}