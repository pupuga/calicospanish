<?php

namespace Pupuga\Modules\Calicosources;

class Level extends Sources
{
    protected $termsDaysIds;
    protected $resourcesTypes;

    public function __construct($atts)
    {
        $this->resourcesTypes = CommonData::app()->getResourcesType();
        parent::__construct($atts);
        $this->setSlug();
        $this->setCurrentBreadcrumb();
        $this->setLevelData();
        $this->setLevelStyle();
        $this->setLessonsData();
    }

    public function getSlug()
    {
        return $this->slug;
    }

    protected function setCurrentBreadcrumb()
    {
        if (isset($this->atts['level'])) {
            $this->breadcrumb[] = [
                'name' => 'Level ' . ucfirst($this->atts['level']),
                'link' => 'level-' . strtolower($this->atts['level'])
            ];
        }
    }

    protected function setSlug()
    {
        $this->slug = sanitize_title($this->atts['template'] . '-' . $this->atts['level']);
    }

    protected function setLevelStyle()
    {
        $this->levelData->levelStyle = $this->slug;
    }

    protected function setLessonsData()
    {
        $unitIds = get_term_children($this->levelData->term_id, 'level');
        $this->getTermsDays();
        foreach ($unitIds as $unitId) {
            $taxonomyData = $this->getTaxonomyData($unitId);
            $countersString = trim(carbon_get_term_meta($unitId, 'sources_levels_counters'));
            $this->setTaxonomiesCount($taxonomyData->slug, $taxonomyData->term_id);
            if (empty($countersString)) {
                $taxonomyData->sources = $this->resourcesTypes;
            } else {
                $taxonomyData->sources = $this->setCustomResources($countersString);
            }
            $taxonomyData->level = $this->slug;
            $taxonomyData->trial = in_array('access_trial', $taxonomyData->access);
            $this->data[] = $taxonomyData;
        }
    }

    protected function setCustomResources($string)
    {
        $resourcesTypes = array();
        $resourcesTypes[] = $this->resourcesTypes[0];
        $sourceStrings = explode(',', $string);
        foreach ($sourceStrings as $sourceString) {
            $sourceString = trim($sourceString);
            $levelSources = explode('=', $sourceString);
            $resourcesTypes[] = array(
                'icon' => $levelSources[0],
                'count' => $levelSources[1],
                'name' => $levelSources[2]
            );
        }

        return $resourcesTypes;
    }

    protected function getTermsDays($return = false)
    {
        $terms = $this->wpdb->terms;
        $termTaxonomy = $this->wpdb->term_taxonomy;
        $sql = 'SELECT t.term_id
                FROM ' . $terms . ' t
                INNER JOIN ' . $termTaxonomy . ' tt ON tt.term_id = t.term_id
                WHERE tt.taxonomy = "day"
                ORDER BY t.slug ASC';
        $this->termsDaysIds = $this->wpdb->get_results($sql);

        if ($return) {
            return $this->termsDaysIds;
        }
    }

    protected function setTaxonomiesCount($slug, $termId)
    {
        $terms = $this->wpdb->terms;
        $termRelationships = $this->wpdb->term_relationships;

        $customCountersStrings = explode(',', str_replace(' ', '', carbon_get_term_meta($termId, 'sources_levels_counters')));
        if ($customCountersStrings) {
            foreach ($customCountersStrings as $customCountersString) {
                $customCountersStringParts = explode('=', $customCountersString);
                $customCounters[$customCountersStringParts[0]] = $customCountersStringParts[1];
            }
        }

        foreach ($this->resourcesTypes as $key => $resourceTypes) {
            if (isset($resourceTypes['terms']) && is_array($resourceTypes['terms']) && count($resourceTypes['terms']) > 0) {
                $types = '"' . implode($resourceTypes['terms'], '", "') . '"';
                $sql = 'SELECT COUNT(*) counter FROM ' . $termRelationships . ' trtypes
                        INNER JOIN ' . $termRelationships . ' trlevel ON trlevel.object_id = trtypes.object_id
                        WHERE trtypes.term_taxonomy_id IN (
                            SELECT t.term_id AS term_ids
                            FROM ' . $terms . ' t 
                            WHERE t.slug 
                            IN (' . $types . ')
                        ) 
                        AND trlevel.term_taxonomy_id IN (
                            SELECT t.term_id
                            FROM ' . $terms . ' t
                            WHERE t.slug = "' . $slug . '"
                        )';
                $counter = $this->wpdb->get_row($sql)->counter;
                $this->resourcesTypes[$key]['count'] = $counter;
            } else {
                $sql = 'SELECT t.term_id
                        FROM ' . $terms . ' t
                        WHERE t.slug = "' . $slug . '"';
                $termLessonId = $this->wpdb->get_row($sql)->term_id;
                $i = 0;
                foreach ($this->termsDaysIds as $termsDaysId) {
                    $sql = 'SELECT COUNT(*) counter
                            FROM ' . $termRelationships . ' trdays
                            INNER JOIN ' . $termRelationships . ' trlesson ON trlesson.object_id = trdays.object_id
                            WHERE trlesson.term_taxonomy_id = ' . $termLessonId . '
                            AND trdays.term_taxonomy_id = ' . $termsDaysId->term_id;
                    $counter = $this->wpdb->get_row($sql)->counter;
                    if ($counter == '' || $counter == 0) {
                        $this->resourcesTypes[$key]['count'] = $i;
                        break;
                    }
                    $i++;
                }
            }
        }
    }
}