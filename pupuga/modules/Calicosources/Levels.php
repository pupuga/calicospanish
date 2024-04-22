<?php

namespace Pupuga\Modules\Calicosources;

final class Levels
{
    private $resourcesType;
    private $levels;
    private $currentLevel = array();
    private $wpdb;

    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->resourcesType = CommonData::app()->getResourcesType();
        $this->setLevels();
        $this->setAdditionalLevelsData();
    }

    public function getLevels()
    {
        return $this->levels;
    }

    private function setLevels()
    {
        $args = array(
            'taxonomy' => 'level',
            'hide_empty' => false,
            'parent' => 0
        );
        $this->levels = get_terms($args);

        return $this;
    }

    private function setAdditionalLevelsData()
    {
        if ($this->levels) {
            foreach ($this->levels as $key => $level) {
                $this->currentLevel['slug'] = $level->slug;
                $imageId = carbon_get_term_meta($level->term_id, 'sources_levels_image');
                $this->levels[$key]->image = wp_get_attachment_image_src($imageId, 'full')[0];
                $this->levels[$key]->title = carbon_get_term_meta($level->term_id, 'sources_levels_title');
                $this->levels[$key]->titlePlus = carbon_get_term_meta($level->term_id, 'sources_levels_title_plus');
                $countersString = trim(carbon_get_term_meta($this->levels[$key]->term_id, 'sources_levels_counters'));
                if (empty($countersString)) {
                    $this->levels[$key]->sources = $this->setAdditionalLevelsSourcesData();
                } else {
                    $this->levels[$key]->sources = $this->setCustomLevelsSourcesData($countersString);
                }
            }
        }
    }

    private function setCustomLevelsSourcesData($string)
    {
        $sources = array();
        $sourceStrings = explode(',', $string);
        foreach ($sourceStrings as $sourceString) {
            $sourceString = trim($sourceString);
            $levelSources = explode('=', $sourceString);
            $sources[] = array(
                'icon' => $levelSources[0],
                'count' => $levelSources[1],
                'name' => $levelSources[2]
            );
        }

        return $sources;
    }


    private function setAdditionalLevelsSourcesData()
    {
        $sources = $this->resourcesType;
        if ($sources) {
            foreach ($sources as $key => $source) {
                if ($source['name'] == 'Daily Lessons') {
                    unset($sources[$key]);
                } else {
                    $this->currentLevel['terms'] = $source['terms'];
                    $sources[$key]['count'] = $this->getSourcesCount();
                }
            }
        }

        return $sources;
    }

    private function getSourcesCount()
    {
        $slug = $this->currentLevel['slug'];
        $terms = '"' . implode('","', $this->currentLevel['terms']) . '"';
        $sql = 'SELECT COUNT(*) counter 
                FROM wp_term_relationships trtypes
                INNER JOIN wp_term_relationships trlevel ON trlevel.object_id = trtypes.object_id
                WHERE trtypes.term_taxonomy_id IN (
                  SELECT t.term_id AS term_ids
                  FROM wp_terms t 
                  WHERE t.slug 
                  IN (' . $terms . ')
                )
                AND trlevel.term_taxonomy_id IN (
                  SELECT t.term_id
                  FROM wp_terms t
                  WHERE t.slug LIKE "' . $slug . '-%"
                )';
        $resources = $this->wpdb->get_row($sql);

        $counter = $resources->counter;

        return $counter;

    }
}