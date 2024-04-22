<?php

namespace Pupuga\Modules\Calicosources;

class CommonData
{
    private static $instance;
    protected $resourcesTypes = [
        ['name' => 'Daily Lessons', 'icon' => 'calendar-check-o'],
        ['name' => 'Videos', 'icon' => 'film', 'terms' => ['story-video', 'music-video', 'dialogue-video']],
        ['name' => 'Songs', 'icon' => 'music', 'terms' => ['songs-music', 'audio-stories']],
        ['name' => 'Activities', 'icon' => 'pencil', 'terms' => ['flash-cards', 'flash-cards-resources', 'activity-sheets']],
        ['name' => 'Games', 'icon' => 'gamepad', 'terms' => ['games']],
        ['name' => 'Resources', 'icon' => 'file-text-o', 'terms' => ['books', 'posters']]
    ];

    private function __construct()
    {
    }

    public static function app()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getResourcesType()
    {
        return $this->resourcesTypes;
    }
}