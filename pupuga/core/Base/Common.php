<?php

namespace Pupuga\Core\Base;

class Common
{
    public $config;
    public $common;
    public $js = array();
    private static $instance;

    private function __construct()
    {
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

    public function getCommon()
    {
        return $this->common;
    }

    /**
     * @param $js array
     *
     * @return $this
     */
    public function addJs($js)
    {
        $this->js = array_merge($this->js, $js);

        return $this;
    }

    public function getJs()
    {
        return json_encode($this->js);
    }

}