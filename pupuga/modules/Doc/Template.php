<?php

namespace Pupuga\Modules\Doc;

class Template
{
    private $docModules;
    public static $instance;

    private function __construct()
    {
    }

    /**
     * @return $this
     */
    static function app()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function setDocModule(templateProperty $data)
    {
        if (is_admin()) {
            $this->docModules[] = $data;
        }
    }

    public function getDocModules()
    {
        return (is_admin()) ? $this->docModules : '';
    }
}