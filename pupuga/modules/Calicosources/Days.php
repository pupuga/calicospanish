<?php

namespace Pupuga\Modules\Calicosources;

use Pupuga\Libs\Files\Files;
use Pupuga\Core\Base\Common;

class Days extends Sources
{
    protected $defaultLessonId = 222;
    protected $access;
    protected $lessonId;
    protected $day;
    protected $dayPosition;
    protected $dayId;
    protected $dayData;
    protected $levelParentData;
    protected $types = array();
    protected $typesSvg = '';
    protected $days = array();
    protected $breadcrumbLesson = array();
    protected $breadcrumbDay = array();

    public function __construct($atts)
    {
        parent::__construct($atts);
        $this->setLessonId()
            ->setDay()
            ->setLevelData()
            ->setAccess()
            ->setSlug()
            ->setLevelStyle()
            ->setTitle()
            ->setDays()
            ->setTypes()
            ->setDayData()
            ->setCurrentBreadcrumb();
    }

    protected function setLessonId()
    {
        $this->lessonId = (isset($_REQUEST['lesson']) && trim($_REQUEST['lesson']) != '') ? intval($_REQUEST['lesson']) : $this->defaultLessonId;

        return $this;
    }

    protected function setLevelData()
    {
        $this->levelData = $this->getTaxonomyData($this->lessonId);

        return $this;
    }

    protected function setAccess()
    {
        if(!is_admin()) {
            $isFreePlanUser = User::app()->isFreePlanUser();
            $this->access = (User::app()->isMember() && (!$isFreePlanUser || ($isFreePlanUser && in_array('access_trial', $this->levelData->access))));
        }

        return $this;
    }

    protected function setDay()
    {
        $this->day = (isset($_REQUEST['day-lesson']) && trim($_REQUEST['day-lesson']) != '') ? intval($_REQUEST['day-lesson']) : 1;

        return $this;
    }

    protected function setSlug()
    {
        $this->slug = $this->levelData->slug;

        return $this;
    }

    protected function setTitle()
    {
        $this->levelData->title = 'Unit ' . $this->levelData->order . ': ' . $this->levelData->title;

        return $this;
    }

    protected function setLevelStyle()
    {
        $this->levelParentData = get_term_by('id', $this->levelData->parent, 'level');
        $this->levelData->levelStyle = $this->levelParentData->slug;

        return $this;
    }

    protected function setCurrentBreadcrumb()
    {
        $this
            ->setBreadcrumbLesson()
            ->setBreadcrumbDay();


        $this->breadcrumb = array_merge($this->breadcrumb, $this->getBreadcrumbLesson());

        return $this;
    }

    protected function setBreadcrumbLesson()
    {
        if ($this->lessonId > 0) {
            $this->breadcrumbLesson = [
                [
                    'name' => $this->levelParentData->name,
                    'link' => $this->levelParentData->slug
                ],
                [
                    'name' => 'Unit ' . $this->levelData->order
                ]
            ];
        }

        return $this;
    }

    protected function setBreadcrumbDay()
    {
        if ($this->dayId > 0) {
            $this->breadcrumbDay = [
                [
                    'name' => $this->levelParentData->name,
                    'link' => $this->levelParentData->slug
                ],
                [
                    'name' => 'Unit ' . $this->levelData->order,
                    'link' => 'day',
                    'class' => 'link-level-form'
                ],
                [
                    'name' => 'Day ' . $this->day,
                ]
            ];
        }

        return $this;
    }

    protected function setDays()
    {
        $terms = get_terms(array(
            'taxonomy' => 'day',
            'orderby' => 'slug',
            'hide_empty' => true,
        ));
        if (count($terms)) {
            $termsId = '';
            $termsIdDay = array();
            foreach ($terms as $term) {
                $termsId .= ($termsId == '') ? $term->term_id : ',' . $term->term_id;
                $termsIdDay[$term->term_id] = ltrim($term->name, '0');
            };
            $termRelationships = $this->wpdb->term_relationships;
            $sql = "SELECT tr.term_taxonomy_id FROM " . $termRelationships . " tr 
                WHERE tr.term_taxonomy_id IN (" . $termsId . ")
                AND tr.object_id IN (
                    SELECT tr.object_id 
	                FROM " . $termRelationships . " tr 
	                WHERE tr.term_taxonomy_id = " . $this->lessonId . "
	            ) 
	            GROUP BY tr.term_taxonomy_id";
            $termsIds = $this->wpdb->get_results($sql);
            foreach ($termsIds as $term) {
                $this->days[] = $termsIdDay[$term->term_taxonomy_id];
                if ($termsIdDay[$term->term_taxonomy_id] == $this->getDay()) {
                    $this->dayId = $term->term_taxonomy_id;
                }
            };
        }

        return $this;
    }

    protected function setDayData()
    {
        $this->dayData = (new Day($this))->getData();

        return $this;
    }

    protected function setTypes()
    {
        $terms = get_terms(array(
            'taxonomy' => 'type',
            'orderby' => 'slug',
            'hide_empty' => true,
        ));

        if (count($terms) > 0) {
            $uploadsDirs = wp_upload_dir();
            $uploadsDir = $uploadsDirs['basedir'];
            foreach ($terms as $term) {
                $iconId = carbon_get_term_meta($term->term_id, 'sources_types_step_icon');
                $iconParams = wp_get_attachment_image_src($iconId);
                $icon = $iconParams[0];
                $this->types[$term->slug] = $icon;
                $path = explode('wp-content/uploads', $icon);
                $file = $path[1];
                if (trim($file) != '') {
                    $this->typesSvg .=
                        str_replace('<g>', '<g class="type-icon type-icon--' . $term->slug . ' type-icon--' . $this->getLevelData()->levelStyle . '" id="type-icon--' . $term->slug . '">', Files::getFile($file, false, '', $uploadsDir));
                }
            }
        }

        Common::app()->common['types_svg'] = $this->typesSvg;

        return $this;
    }

    public function getAccess()
    {
        return $this->access;
    }

    public function getDay()
    {
        return $this->day;
    }

    public function getDayId()
    {
        return $this->dayId;
    }

    public function getDayPosition()
    {
        switch ($this->getDay()) {
            case 1:
                $this->dayPosition = 'first';
                break;
            case count($this->getDays()):
                $this->dayPosition = 'last';
                break;
            default:
                $this->dayPosition = 'middle';
        }

        return $this->dayPosition;
    }

    public function getDayData()
    {
        return $this->dayData;
    }

    public function getLevelData()
    {
        return $this->levelData;
    }

    public function getDays()
    {
        return $this->days;
    }

    public function getTypes()
    {
        return $this->days;
    }

    public function getTypesSvg()
    {
        return $this->typesSvg;
    }

    public function getBreadcrumbLesson()
    {
        return $this->breadcrumbLesson;
    }

    public function getBreadcrumbDay()
    {
        return $this->breadcrumbDay;
    }

}