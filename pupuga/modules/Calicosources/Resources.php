<?php

namespace Pupuga\Modules\Calicosources;

class Resources extends Sources
{
    protected $access;
    protected $type;
    protected $level;
    protected $sql;
    protected $converted = [];
    protected $resources;
    protected $params;
    protected $currentResource;
    protected $addLevels = [
        'All levels'
    ];
    protected $requestParams = [
        'type' => null,
        'level' => null
    ];
    protected $excludeTypes = [];
    protected $typesFilter = [
        'story-video' => [
            'filter' => 'module',
            'value' => 'video_hosting_url'
        ],
        'music-video' => [
            'filter' => 'module',
            'value' => 'video_hosting_url'
        ],
        'dialogue-video' => [
            'filter' => 'module',
            'value' => 'video_hosting_url'
        ],
        'songs-music' => [
            'filter' => 'module',
            'value' => 'source_audio'
        ],
        'audio-stories' => [
            'filter' => 'module',
            'value' => 'video_hosting_url'
        ],
        'flash-cards-resources' => [
            'filter' => 'module',
            'value' => 'source_media'
        ],
        'activity-sheets' => [
            'filter' => 'file',
            'value' => 'source_pdf'
        ],
        'games' => [
            'filter' => 'file',
            'value' => 'source_pdf'
        ],
        'books' => [
            'filter' => 'file',
            'value' => 'source_pdf'
        ],
        'posters' => [
            'filter' => 'file',
            'value' => 'source_pdf'
        ],
    ];

    public function __construct($atts)
    {
        parent::__construct($atts);
        $this->setSlug();
        $this->setCurrentBreadcrumb();
        $this->setAccess();
        $this->setTypes();
        $this->setCurrentType();
        $this->setTypesExtended();
        $this->setLevelsExtended();
        $this->setRequestParams();
        if ($this->getAccess()) {
            $this->setResources();
        }
    }

    protected function setAccess()
    {
        $this->access = (User::app()->isMember() && !User::app()->isFreePlanUser());

        return $this;
    }

    protected function setSlug()
    {
        $this->slug = sanitize_title($this->atts['level']);
    }

    protected function setCurrentBreadcrumb()
    {
        if (isset($this->atts['level'])) {
            $this->breadcrumb[] = [
                'name' => ucfirst($this->atts['level']),
            ];
        }
    }

    protected function setCurrentType()
    {
        $this->currentResource['type'] = substr($_GET['type'], 0, 50);
        if (empty($this->currentResource['type'])) {
            $this->currentResource['type'] = $this->type[0]->slug;
        }
    }

    protected function convertTermsToKeyValue($terms)
    {
        $convertedArray = array();
        if (count($terms) > 0) {
            foreach ($terms as $term) {
                $convertedArray[$term->slug] = $term->name;
            }
        }

        return $convertedArray;
    }

    protected function setTypes()
    {
        $args = array(
            'taxonomy' => 'type',
            'hide_empty' => false,
            'exclude_tree' => $this->excludeTypes
        );
        $this->type = get_terms($args);
    }

    protected function setTypesExtended()
    {
        if (count($this->type) > 0) {
            foreach ($this->type as $key => $term) {
                $iconId = carbon_get_term_meta($term->term_id, 'sources_types_passive_icon');
                if (!empty($iconId) && $iconId > 0) {
                    $this->type[$key]->iconGray = wp_get_attachment_image_src($iconId)[0];
                    $iconId = carbon_get_term_meta($term->term_id, 'sources_types_active_icon');
                    $this->type[$key]->iconColor = wp_get_attachment_image_src($iconId)[0];
                    if ($this->currentResource['type'] == $term->slug) {
                        $this->currentResource['content'] = carbon_get_term_meta($term->term_id, 'sources_types_content_on_resources_page');
                    }
                } else {
                    unset($this->type[$key]);
                }
            }
        }
    }

    protected function setLevels()
    {
        $args = array(
            'taxonomy' => 'level',
            'hide_empty' => false,
            'parent' => 0

        );
        $this->level = get_terms($args);
    }

    protected function setLevelsExtended()
    {
        $this->setLevels();
        if (count($this->addLevels) > 0) {
            foreach ($this->addLevels as $level) {
                $object = new \stdClass();
                $object->name = $level;
                $object->slug = sanitize_title($object->name);
                $object->term_id = 0;
                $this->level[] = $object;
            }
        }
    }

    protected function setRequestParams()
    {
        if (count($this->requestParams) > 0) {
            foreach ($this->requestParams as $key => $value) {
                $termsArray = $this->converted[$key] = $this->convertTermsToKeyValue($this->$key);
                if (isset($_GET[$key]) && strlen(trim($_GET[$key])) > 0 && isset($termsArray[$_GET[$key]])) {
                    $this->requestParams[$key] = sanitize_title(substr($_GET[$key], 0, 50));
                } else {
                    $nameAllLevels = 'all-levels';
                    $this->requestParams[$key] = (isset($termsArray[$nameAllLevels])) ? $nameAllLevels : key($termsArray);
                }
            }
        }
    }

    protected function setResources()
    {
        $type = $this->getRequestParams('type');
        $level = $this->getRequestParams('level');
        $filter = $this->typesFilter[$type];
        switch ($filter['value']) {
            case 'source_audio':
                $kind = 'audio';
                break;
            case 'video_hosting_url':
                $kind = 'video';
                break;
            case 'source_media':
                $kind = 'gallery';
                break;
            case 'source_pdf':
                $kind = 'file';
                break;
            default :
                $kind = null;
        }
        $this->params = array(
            'type' => $type,
            'level' => $level,
            'filter' => $filter['filter'],
            'filter_value' => $filter['value'],
            'kind' => $kind
        );
        $sql = ResourcesSql::app($this->params)->getSql();
        $this->wpdb->query('START TRANSACTION');
        $this->wpdb->query('SET SESSION group_concat_max_len = 1000000');
        $resources = $this->wpdb->get_results($sql);
        $this->wpdb->query('COMMIT');
        $this->resources = (new TypeResource(['resources' => $resources, 'params' => $this->params]))->getResources();
    }

    public function getAccess()
    {
        return $this->access;
    }

    public function getTypes()
    {
        return $this->type;
    }

    public function getLevels()
    {
        return $this->level;
    }

    public function getCurrentType()
    {
        $currentType = $this->converted['type'][$this->requestParams['type']];
        $currentType = str_replace(' (Resources)', '', $currentType);

        return $currentType;
    }

    public function getCurrentLevel()
    {
        return $this->converted['level'][$this->requestParams['level']];
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function getRequestParams($key)
    {
        $value = (isset($this->requestParams[$key])) ? $this->requestParams[$key] : '';
        return $value;
    }

    public function getResources()
    {
        return $this->resources;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getContent()
    {
        return $this->currentResource['content'];
    }
}