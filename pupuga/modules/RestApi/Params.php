<?php

namespace Pupuga\Modules\RestApi;

class Params
{
    public static $instance;
    private $config;

    public function __construct()
    {
        $this->config = (object)'restApiConfig';
        $this->config->name = 'rest-api';
        $this->config->version = 'v1';
    }

    public function __set($name, $value)
    {
        $this->config->$name = $value;

        return $this->config;
    }

    static public function app()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConfig()
    {
        return $this->config;
    }

}
